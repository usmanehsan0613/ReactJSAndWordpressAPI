'use strict';

import React from 'react';
import { Link } from 'react-router';
import constants from '../data/constants';
 
export default class Layout extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      currentLang : localStorage.getItem('current_lang')
    }
  }

  componentDidMount(){
    if(typeof this.state.currentLang == "undefined" || this.state.currentLang == null)
    {
      this.setState({ currentLang : 'ar' });
      localStorage.setItem('current_lang', 'ar');
      
    }
    //const CurrentLang = React.createContext(this.state.currentLang);
  }

  render() {
  
    return (
      <div className={`app-container lang-${this.state.currentLang}`}>
       
        <div className={`col-lg-12 col-xs-12 opendata-header lang-${this.state.currentLang}`}>
            
            {(this.state.currentLang == "en") 
             ?
             (
                <p className={`lang-${this.state.currentLang}`}>{constants.toview} 
                <a className="external-link" href="http://data.bayanat.ae/en_GB/organization/zayed-university" target="_blank">{constants.bayanatLink}</a>
                </p>
             ) 
            : 
             (

              <p className={`lang-${this.state.currentLang}`}>{constants.toview_ar} 
                <a className="external-link" href="http://data.bayanat.ae/en_GB/organization/zayed-university" target="_blank">{constants.bayanatLink_ar}</a>
              </p>
             )

            }
        </div>

        <div className={`app-content opendata-content lang-${this.state.currentLang}`}>{this.props.children}</div>
        
        <footer className={`col-lg-12 col-xs-12 no-margin lang-${this.state.currentLang}`}>
          
          <div className="col-lg-4 col-xs-4 pull-left policy">
            <a className="pull-left" href="https://www.zu.ac.ae/main/files/contents/OpenDataPolicyEn.pdf" target="_blank">
              <img src={`${constants.assetsURL}images/pdf.svg`} alt="OpenDataPolicyEn" width="30" />
            </a>
             
             <a className="pull-left" href="https://www.zu.ac.ae/main/en/open-data-policy.aspx" target="_blank">
               {constants['opendataUsagePolicy_'+this.state.currentLang]}
             </a>

          </div>

          <div className="col-lg-4 col-xs-4 pull-left">
            <a className="pull-left" href="https://www.zu.ac.ae/main/files/contents/open_data/UseOpenData.pdf" target="_blank">
              <img className="pull-left" src={`${constants.assetsURL}images/pdf.svg`} alt="How to use Open data" width="30" />&nbsp;&nbsp;
                {constants['howToUseOpenData_'+this.state.currentLang]}
              
            </a>
          </div>

          <div className="col-lg-4 col-xs-4 pull-left">
            <a className="pull-left" href="https://www.zu.ac.ae/main/files/contents/open_data/OpenDataDictionary.xlsx" target="_blank">
              <img className="pull-left" src={`${constants.assetsURL}images/xls.svg`} alt="Open Data Dictionary" width="30" />&nbsp;&nbsp;
              {constants['openDataDictionary_'+this.state.currentLang]}
            </a>
          </div>

        </footer>
      </div>
    );
  }
}
