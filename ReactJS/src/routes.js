'use strict';

import React from 'react'
import { Route, IndexRoute } from 'react-router'
import Layout from './components/Layout';
import IndexPage from './components/IndexPage';
import NotFoundPage from './components/NotFoundPage';

 

const routes = (
  // <Route path="/react" component={Layout}> to deploy on localhost/react notice react in path name
  ///apps/eclc/react
  // main/en/opendata
  /// main/ar/opendata
  //  <Route path="*" component={IndexPage}/> for zu.ca.e need to figure out routes

  <Route path="/" component={Layout}>
    <IndexRoute component={IndexPage}/>
    <Route path="*" component={NotFoundPage}/>
  </Route>
);

export default routes;