#!/usr/bin/env python2
#-*- coding: utf-8 -*-

import os

import jinja2

from google.appengine.ext import webapp
from google.appengine.ext import db
from google.appengine.ext.webapp.util import run_wsgi_app

jinja_environment = jinja2.Environment(
    loader=jinja2.FileSystemLoader(os.path.dirname(__file__)))

class TrainData(db.Model):
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
        # data
        self.redirect('/thanks')


class ThanksHandler(webapp.RequestHandler):
    def get(self):
        self.response.out.write(
                jinja_environment.get_template('tpl/thanks.html').render())


app = webapp.WSGIApplication([
                                ('/', IndexHandler),
                                ('/train', TrainHandler),
                                ('/thanks', ThanksHandler),
                             ], debug=True)

if __name__ == '__main__':
    run_wsgi_app(app)

