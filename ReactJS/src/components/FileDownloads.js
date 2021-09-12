'use strict';

import React from 'react';
import { Link } from 'react-router';
import base64 from 'base-64';
import constants  from '../data/constants';

export default class FileDownloads extends React.Component {
    constructor(props){
        super(props);
        this.state = {
            postID : props.postID,
            postsMeta : props.postMeta // all meta values of particular post - one single post
        }
    }

    displayDownloads(){
        
        let str = '';
        if(typeof this.state.postsMeta != "undefined"){
           
            let metaVals = this.state.postsMeta;
              
            for(let i=0; i<metaVals.type.length; i++){
                //console.log(metaVals.type[i]);
                // console.log(metaVals.download+'_'+metaVals.type[i]+'');  
                if( metaVals.type[i] != "undefined" || metaVals.type[i] != null )
                {
                    let type = metaVals.type[i];
                    let downloadURl = metaVals['download_'+type+'']
                    str += `<a href="${downloadURl}" target="_blank"><img src="${constants.assetsURL}images/${type}.svg" alt="${downloadURl}" width="30" /></a>`;
                }
            }
            return{__html : str};
        }
    }

    myDisplay(){
        return <div dangerouslySetInnerHTML={this.displayDownloads()} />;
    }

    render(){
       
        return(<div className="downloads">
                 {this.myDisplay()}
            </div>);
    
    }
}