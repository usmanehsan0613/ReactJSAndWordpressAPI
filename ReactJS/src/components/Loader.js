'use strict';

import React from 'react';
export default class Loader extends React.Component {

    constructor(props){
        super(props);
      }
    
     render() {
        return(<div className="od-loader"><div></div><div></div><div></div><div></div></div>);
    }
}