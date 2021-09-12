import React from 'react';
import { Link } from 'react-router';
import constants from '../data/constants'
import DataPreview from './DataPreview';

export default class SearchHeader extends React.Component
{
    
    
    constructor(props){
        super(props);
        this.state= {
            totalFiles : 0,
            totalCategoriesAndFiles : [],
            dataReceived : false
        }
    }

    fetchData(opendata){
        this.setState({
             dataReceived : true,  
             totalCategoriesAndFiles : opendata, 
             totalFiles : opendata.length
        }); 

      

        //console.log(opendata);
        //console.log(this.state);
    }

    componentDidMount(){
        console.warn('SearchHeader componentDidMount message t'); 
        fetch(constants.category).then(res => res.json())
            .then(categories => {
                // console.warn(categories);
                this.setState({ dataReceived : true,  totalCategoriesAndFiles : categories }, ()=> { this.fetchData(categories) });
            }); 
    }

    render() {
        // console.warn('SearchHeader render '); 
        //console.log(this.state.totalCategoriesAndFiles.length);

        const packData = this.state.totalCategoriesAndFiles;
        const len = this.state.totalCategoriesAndFiles.length;
        let statement, lop;

        if(len > 0){
            statement = <p>Length is ok</p>
             
        }else{
            statement = <p>Length is zero</p>
        }
        
        console.log(lop);

        return (
            <div className="opendata-header">
                  <div className="wrapper">
                      {(this.state.dataReceived == true) ? 
                      <p>Data recevied.</p>
                      
                      : <p>Not loaded...</p>
                      }
                        <p>Content will go ehre.</p>
                        {/*console.log(this.state.totalCategoriesAndFiles)*/}
                        {statement}
                      
                        {packData.map(data => <DataPreview key={data.id} {...data} />)}
                        {packData.map( (data)=>{
                          console.log(data.name);
                           
                        })}
                     </div>
                <div className="metrics">
                    <div className="metric pull-left">
                        { (this.state.totalFiles > 0 ) ? 
                            <p> {this.state.totalFiles} total files</p>
                        : 
                            <p></p>
                        }  
                    </div>
                  
                    
                </div>
                <div className="searchbar">

                </div>

            </div>
        );
    }
}