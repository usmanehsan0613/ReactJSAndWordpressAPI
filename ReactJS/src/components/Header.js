'use strict';

import React from 'react';
import { Link } from 'react-router';
import constants from '../data/constants';

export default class Header extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            selectedCategory: "",
            selectedYear : 2021
           
        }
        this.handleChange = this.handleChange.bind(this);
     }

    componentDidMount(){
        //console.log('componentDidMount');
        if( this.props.headerStateVal != null)
            this.setState({ selectedCategory: this.props.headerStateVal.categoryId});
    }

    myrender( item ){
        return(<section>
                <span>{item.cat_name}</span>
                <span>{item.category_count}</span>
                </section>);
    }

    handleChange(e){
        e.preventDefault();
        //console.log(e);
        // console.log(e.target.getAttribute("data-id"));
        //console.log(e.target.id);
        const id = e.target.id;
        let valuss = {};
        valuss.dataReceived = false;
        valuss.categoryId = id;
        this.setState({ selectedCategory : id});
        // method originally at Parent side,
        // getting method via props and using it on client to send data back to parent
        this.props.stateHandler(valuss);
    }

  render() {
    //console.warn('header.js');
    //console.log(this.props);
    return (
        <div className={`opendata lang-${this.props.currentLang}`}>
            <div className="wrapper-categories col-lg-12 col-xs-12 no-margin no-padding">
                <ul>
                    <li>
                        <a href="#" id="0"  data-id="0" onClick={this.handleChange} >
                            <img src={`${constants.assetsURL}images/total.svg`} id="0"  data-id="0" alt="TotalDownloads" width="50" data-toggle="tooltip"  />
                            <div className="files" id="0"  data-id="0" >
                                {constants['totalNumberFiles_'+this.props.currentLang]}
                               <span className="all">{this.props.total}</span>
                             </div> 
                        </a>  
                    </li>
                    {this.props.categories.map( (item, index)=>{
                        if(item.cat_name != null){
                            // return(this.myrender(item));    also works
                            return(<li key={index} >
                                    <a href="#" id={item.cat_ID}  data-id={item.cat_ID} onClick={this.handleChange} >
                                    <img src={`${constants.assetsURL}images/${item.slug}.svg`} id={item.cat_ID}  data-id={item.cat_ID} alt="TotalDownloads" width="50" data-toggle="tooltip"  />
                                            <div className="files" id={item.cat_ID}  data-id={item.cat_ID} >
                                            {(this.props.currentLang == "ar") ? item.category_description : item.cat_name}
                                             <span className="">{item.category_count}</span>
                                            </div> 
                                        </a>  
                                    </li>)
                            }
                    })}
                </ul>
                </div>
                <div className="clear"></div>
                <div className="col-lg-12 col-xs-12 download-datasets">
                    <a className="bulk-download pull-left" href="https://allt-uae.zu.ac.ae/www-zu/wp-content/uploads/sites/2/2021/09/datasets.zip">
                        <i className="fa fa-download"></i>{constants['downloadDataSets_'+this.props.currentLang]}
                    </a>
                    <small className="pull-left hint">
                        <i className="fa fa-info-circle"></i>
                            {constants['beAware_'+this.props.currentLang]}
                    </small>
                </div>  
           
       
        </div>
    );
  }
}
