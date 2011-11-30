#!/usr/bin/env python2
#-*- coding: utf-8 -*-


from google.appengine.ext import webapp
from google.appengine.ext.webapp.util import run_wsgi_app

class IndexHandler(webapp.RequestHandler):
    def get(self):
        self.response.out.write('oh no')

app = webapp.WSGIApplication([
                                ('/', IndexHandler),
                             ], debug=True)

if __name__ == '__main__':
    run_wsgi_app(app)

