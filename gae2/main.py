#!/usr/bin/env python2
#-*- coding: utf-8 -*-

import os

import jinja2

from google.appengine.ext import webapp
from google.appengine.ext import db
from google.appengine.ext.webapp.util import run_wsgi_app

jinja_environment = jinja2.Environment(
    loader=jinja2.FileSystemLoader(os.path.dirname(__file__)))

class GiftData(db.Model):
    gift = db.StringProperty()
    price = db.IntegerProperty()
    tech = db.IntegerProperty()
    culture = db.IntegerProperty()
    games = db.IntegerProperty()
    sports = db.IntegerProperty()
    clothing = db.IntegerProperty()


class IndexHandler(webapp.RequestHandler):
    def get(self):
        self.response.out.write(
                jinja_environment.get_template('tpl/index.html').render())


class TrainHandler(webapp.RequestHandler):
    def get(self):
        self.response.out.write(
                jinja_environment.get_template('tpl/train.html').render())

    def post(self):
        try:
            # check limits
            gift = self.request.get('gift')
            price = int(self.request.get('price'))
            tech = int(self.request.get('tech'))
            culture = int(self.request.get('culture'))
            games = int(self.request.get('games'))
            sports = int(self.request.get('sports'))
            clothing = int(self.request.get('clothing'))

            if any((not x for x in (gift, price, tech, culture, games, sports, clothing))):
                raise ValueError('Oh no!')

            for gift in gift.split(','):
                g = GiftData()
                g.gift = gift.strip()
                g.price = price
                g.tech = tech
                g.culture = culture
                g.games = games
                g.sports = sports
                g.clothing = clothing
                g.put()

        except ValueError, Exception:
            # erreur une des valeurs entières ne l'était pas/ou pas d'idée de cadeau
            pass

        self.redirect('/thanks')


class ShowHandler(webapp.RequestHandler):
    def get(self):
        for g in GiftData.all():
            self.response.headers['Content-Type'] = 'text/csv'
            self.response.out.write('"%s", %d, %d, %d, %d, %d, %d\n'
                    % (g.gift, g.price, g.tech, g.culture, g.games, g.sports,
                        g.clothing))

class ThanksHandler(webapp.RequestHandler):
    def get(self):
        self.response.out.write(
                jinja_environment.get_template('tpl/thanks.html').render())


app = webapp.WSGIApplication([
                                ('/', IndexHandler),
                                ('/train', TrainHandler),
                                ('/thanks', ThanksHandler),
                                ('/show', ShowHandler),
                             ], debug=True)

if __name__ == '__main__':
    run_wsgi_app(app)

