'use strict';

import React, { Suspense } from 'react';
import Header from './Header'
import Likes from './Likes';
import FileDownloads from './FileDownloads';
import constants  from '../data/constants';
import Loader from './Loader';
 
 

// http://localhost/zupress/open-data/wp-json/zutheme/v1/latest-posts/4
export default class IndexPage extends React.Component {

  constructor(props){
    super(props);
       this.state = {
        opendatas: [],
        categories: [],
        total_downloads : 0,
        posts : [],
        posts_meta : [],
        isValid : true, 
        dataReceived : false, 
        headerStateVal : null,
        currentLang : localStorage.getItem('current_lang')
       
      }
     //z this.some = this.some.bind(this);
     this.updateState = this.updateState.bind(this);
     
  }

  fetchDataCallback(opendata){
    //console.warn('fetchDataCallback '); 
    
    this.setState(
      { 
        dataReceived    : true, 
        opendatas       : opendata,
        posts           : opendata.posts,
        posts_meta      : opendata.posts_meta,
        categories      : opendata.category,
        total_downloads : opendata.total_downloads,
      }
      ); 
  }


  fetchData(catId,year, keyword){
    
    let fetchUrl;

    if( typeof catId == "undefined"  ){
      catId = 0;
    }

    fetchUrl = constants.generalData+catId;

    if( (typeof year !== "undefined" && year > 2000) ){
      if( typeof catId == "undefined" || catId == null || catId == ""){
        catId = 0;
      }   
      //console.warn('inside year');
      fetchUrl = constants.generalData+"year/"+year+"/category/"+catId;
    }
    
    if(typeof keyword != "undefined" && keyword != null){
      // console.warn(fetchUrl);
      fetchUrl += "/keyword/"+keyword;
    }

    // console.warn(fetchUrl);

    fetch(fetchUrl).then(res => res.json())
    .then( opendata => {
      //console.log( opendata); 
      this.setState(
          { dataReceived    : true,  
            opendatas       : opendata , 
            posts           : opendata.posts,
            posts_meta      : opendata.posts_meta,
            categories      : opendata.categories,
            total_downloads : opendata.total_downloads,
          }, ()=> { this.fetchDataCallback(opendata) });
    })  
  }
  
  componentDidMount(){
    this.fetchData();
  }

  componentWillMount(){
    //console.warn('componentWillMount');
  }

  // getting params from child and updating the state of parent.
  updateState( stateVal ){
    //console.log('Parent updateState');
    //console.log(stateVal);
    this.setState({dataReceived: false, headerStateVal : stateVal });
    this.fetchData( stateVal.categoryId, stateVal.selectedYear, stateVal.searchKeyword );

  } 

  likePost(event){
    //console.log('likePost');
    let postID = event.target.value;
  }
  render() {
    //console.log('this.state.opendatas');
    //console.log('Parent render');
    let TpostsMeta = this.state.posts_meta;
    // console.log(TpostsMeta[10].likes);
    const Tposts = [];
    let Tstateposts = this.state.posts;
    
    for (const key in Tstateposts) {
       Tstateposts[key].posts.map( (item, index) => {
        Tposts.push(item);
       })
    }

     
    
    return (
     
        <div className="home">
          { ( (this.state.dataReceived) && (this.state.categories != null) ) ? 
          <Header categories={this.state.categories} total={this.state.total_downloads} {...this.state.opendata} 
            stateHandler={this.updateState}
            currentLang={this.state.currentLang}
            headerStateVal={this.state.headerStateVal}
          />
          :  (<p></p>)
          }
          
          <div className="opendata">
            {(!this.state.dataReceived) ?
              <Loader/>
            :  
            <div className="data-body col-lg-12 col-xs-12 no-margin no-padding">
              {Tposts.map( (item, index) => {
                    return(<div className="col-lg-4 col-xs-6 data-item" key={index}>
                              <h5>
                                {(this.state.currentLang == "ar") ? TpostsMeta[item.ID].title_arabic : item.post_title}
                              </h5>
                              <small>{constants['dateCreated_'+this.state.currentLang]}: {TpostsMeta[item.ID].format_post_date}</small>
                              <FileDownloads key={index} postMeta={TpostsMeta[item.ID]} postID={item.ID} />
                              <div className="badge">
                                <img src={`${constants.assetsURL}images/${TpostsMeta[item.ID].badge}.jpg`} alt="Support SGSs No . 4" width="40" />
                              </div>
                              <div className="rate-block">
                                <Likes key={index} likesCount={TpostsMeta[item.ID].likes} postID = {item.ID} currentLang={this.state.currentLang}/>
                              </div>
                          </div>) 
                  })}
          </div>
          }
            
          </div>
        </div>
      
      
       
    );
  }
}
