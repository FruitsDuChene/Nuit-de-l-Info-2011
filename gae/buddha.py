#!/usr/bin/env python2
#-*- coding: utf-8 -*-

# TODO
# - templates
# - try catché les int()
# - checker bornes params (+ xmin != xmax ...)
# - img handler check finalized
# - var pour les defaults values
# - créer le bmp une fois pour toute et non pas à chaque fois qu'on demande /img

import jinja2
import os

import logging
import random

import bmp
import pipeline

from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app

jinja_environment = jinja2.Environment(
    loader=jinja2.FileSystemLoader(os.path.dirname(__file__)))

# ça c'est juste pour éviter d'être loggué
pipeline.set_enforce_auth(False)

jinja_environment = jinja2.Environment(
    loader=jinja2.FileSystemLoader(os.path.dirname(__file__)))

class IndexHandler(webapp.RequestHandler):
    # GET
    def get(self):
	# Default values for budha	
	config = {
		'width' : 		64,
		'height' : 		64,
		'red': 			5,
		'green' : 		50,
		'blue' : 		500,
		'xmin' : 		-2,
		'xmax' : 		1,
		'ymin' : 		-1.5,
		'ymax' : 		1.5,
		'pointspermapper' : 	256,
		'numberofmappers' : 	4,
	}
	# Get template with set values
	head_template = jinja_environment.get_template('head.html')
        budha_form_template = jinja_environment.get_template('BudhaGenerator.html')
	
	# Write responses
        self.response.out.write(head_template.render(title = "Buddhabrot Generator"))
	self.response.out.write(budha_form_template.render(config))
    
    # POST
    def post(self):
	# Store posted data  
	config = {}      
	config['width'] = int(self.request.get('width'))
        config['height'] = int(self.request.get('height'))

        config['red'] = int(self.request.get('red'))
        config['green'] = int(self.request.get('green'))
        config['blue'] = int(self.request.get('blue'))

        config['xmin'] = float(self.request.get('xmin'))
        config['xmax'] = float(self.request.get('xmax'))
        config['ymin'] = float(self.request.get('ymin'))
        config['ymax'] = float(self.request.get('ymax'))

        config['pointspermapper'] = int(self.request.get('pointspermapper'))
        config['numberofmappers'] = int(self.request.get('numberofmappers'))

        # c'est le pipeline qui va faire les calculs
        bp = BuddhaPipeline(config)
        bp.start()

        self.response.out.write('''
            <a href="/res?pid=%s">result</a>''' % bp.pipeline_id)
        self.response.out.write('''
            <a href="/_ah/pipeline/status?root=%s">status</a>''' % bp.pipeline_id)


# L'ideal serait de normaliser le nom de l'image generée 
# utilisateur logué genere une image nomé : login_budha.bmp
# Script ajax cherchera l'image toute les x secondes et demande a l'utilisateur de bien vouloir attendre
class ResultHandler(webapp.RequestHandler):
    def get(self):
        # affiche :( si le calcul n'est pas fini, ou le résultat s'il est fini
        pid = self.request.get('pid')
        bp = BuddhaPipeline.from_id(pid)

        if bp.has_finalized:
            self.response.out.write('<img src=/img?pid=%s>' % pid)

        else:
            self.response.out.write(''':(''')

class ImgHandler(webapp.RequestHandler):
    def get(self):
        # génère l'image qui correspond au buddha
        # probablement pas très efficace
        pid = self.request.get('pid')
        bp = BuddhaPipeline.from_id(pid)

        rgrid, ggrid, bgrid = bp.outputs.default.value
        width = len(rgrid[0])
        height = len(rgrid)

        # ugly
        ra = min(min(g) for g in rgrid)
        rb = max(max(g) for g in rgrid)

        ga = min(min(g) for g in ggrid)
        gb = max(max(g) for g in ggrid)

        ba = min(min(g) for g in bgrid)
        bb = max(max(g) for g in bgrid)

        self.response.headers["Content-Type"] = "image/bmp"
        img = bmp.BitMap(width, height)

        # enumerate
        for y in range(len(rgrid)):
            for x in range(len(rgrid[y])):
                r = int(round(255.0 * (rgrid[x][y] - ra) / (rb - ra)))
                g = int(round(255.0 * (ggrid[x][y] - ga) / (gb - ga)))
                b = int(round(255.0 * (bgrid[x][y] - ba) / (bb - ba)))
                img.setPenColor(bmp.Color(r, g, b))
                img.plotPoint(x, y)

        self.response.out.write(img.getBitmap())

class BuddhaReducer(pipeline.Pipeline):
    def run(self, config, *grids):
        """additionne toutes le nombre d'occurence de chaque point
        pour chaque couleur"""
        width = config['width']
        height = config['height']

        rgrid = [[0] * width for _ in range(height)]
        ggrid = [[0] * width for _ in range(height)]
        bgrid = [[0] * width for _ in range(height)]

        for i in range(height):
            for j in range(width):
                # ugly
                rgrid[i][j] = sum(g[0][i][j] for g in grids)
                ggrid[i][j] = sum(g[1][i][j] for g in grids)
                bgrid[i][j] = sum(g[2][i][j] for g in grids)

        return (rgrid, ggrid, bgrid)

class Cpx2Px:
    # nombre imagaire -> pixel
    def __init__(self, xmin, xmax, ymin, ymax, width, height):
        # self.xxx useles (pas sûr en fait)
        self.xmin = xmin
        self.xmax = xmax
        self.ymin = ymin
        self.ymax = ymax

        self.width = width
        self.height = height

        self.xratio = width / (xmax - xmin)
        self.yratio = height / (ymax - ymin)

    def __call__(self, p):
        x = int(round((p.real - self.xmin) * self.xratio))
        y = int(round((self.ymax - p.imag) * self.yratio))

        if x < 0 or x >= self.width or y < 0 or y >= self.height:
            return None

        return x, y

class BuddhaMapper(pipeline.Pipeline):
    def run(self, config):
        width = config['width']
        height = config['height']

        red = config['red']
        green = config['green']
        blue = config['blue']

        xmin = config['xmin']
        xmax = config['xmax']
        ymin = config['ymin']
        ymax = config['ymax']

        pointspermapper = config['pointspermapper']

        maxiter = max(red, green, blue)

        rgrid = [[0] * width for _ in range(height)]
        ggrid = [[0] * width for _ in range(height)]
        bgrid = [[0] * width for _ in range(height)]

        cpx2px = Cpx2Px(xmin, xmax, ymin, ymax, width, height)

        logging.info(cpx2px(0j))

        for _ in range(pointspermapper):
            c = random.uniform(xmin, xmax) + random.uniform(ymin, ymax) * 1j
            z = c ** 2
            i, points = 0, [c]

            # TODO prendre le carré  < 4 => ++perf
            while i < maxiter and abs(z) < 2:
                z = z ** 2 + c
                i += 1
                points.append(z)

            #points.append(z)

            if i < red:
                for p in points:
                    a = cpx2px(p)

                    if a is not None:
                        x, y = a
                        #logging.info('x: %d, y: %d' % (x, y))
                        rgrid[x][y] += 1

            if i < green:
                for p in points:
                    a = cpx2px(p)

                    if a is not None:
                        x, y = a
                        #logging.info('x: %d, y: %d' % (x, y))
                        ggrid[x][y] += 1

            if i < blue:
                for p in points:
                    a = cpx2px(p)

                    if a is not None:
                        x, y = a
                        bgrid[x][y] += 1

        return (rgrid, ggrid, bgrid) # check list

class BuddhaPipeline(pipeline.Pipeline):
    def run(self, config):
        numberofmappers = config['numberofmappers']
        mappers = [(yield BuddhaMapper(config)) for _ in range(numberofmappers)]
        yield BuddhaReducer(config, *mappers)


app = webapp.WSGIApplication([
                                ('/', IndexHandler),
                                ('/res', ResultHandler),
                                ('/img', ImgHandler),
                             ], debug=True)

if __name__ == '__main__':
    run_wsgi_app(app)

