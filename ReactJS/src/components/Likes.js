'use strict';

import React from 'react';
import { Link } from 'react-router';
import base64 from 'base-64';
import constants  from '../data/constants';

export default class Likes extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      postID : props.postID,
      likesCount : props.likesCount,
      error: "Already liked.",
      errorComment : "Error posting comments",
      successComment : "Successfully posted",
      alreadyLikedposts : []
    }

    this.handleLikes = this.handleLikes.bind(this);
    this.postComment = this.postComment.bind(this);

  }

  showError(id){
    // document.getElementById(id).innerHTML = this.state.error;
    document.getElementById(id).innerHTML = constants['errorComment_'+this.props.currentLang]
  }
  showErrorComments(id, type){
    let msg;
    let ele = document.getElementById('comments_response_'+id);
    if(type == 'error'){
      // msg = this.state.errorComment;
      msg = constants['errorComment_'+this.props.currentLang];
      ele.classList.toggle("hidden");
      ele.classList.toggle("error");
    }
    else
    {
      // msg = this.state.successComment;
      msg = constants['success_'+this.props.currentLang];
      ele.classList.toggle("hidden");
      ele.classList.toggle("success");
    }
    ele.innerHTML = msg;
  }

  updateLikedList(id){
    let list = this.state.alreadyLikedposts;
    if(list.includes(id)){
      // this.showError(id);
      return true;
    }
    list.push(id);
    this.setState({ alreadyLikedposts: list});
  }

  renderCommentBox(id){
    const ele = document.getElementById('comments_'+id);
     ele.classList.toggle("hidden");
  }

  postComment(e){
    console.log(e);
    let postCommentID = e.target.getAttribute('data-id');
    let commetn = document.getElementById('txt_'+postCommentID).value;
   
    if(commetn != null && typeof commetn != "undefined")
    {
      let headers = new Headers();
      const data = JSON.stringify({
        post: postCommentID,
        author_name:  constants.author_name,
        author_email:  constants.author_email,
        content: commetn,
      });
      //'http://localhost/zupress/open-data/wp-json/wp/v2/comments';
    let url = constants.comments; 
        fetch(url, {
          method: 'POST',
          headers: new Headers({
            'Content-Type': 'application/json',
          }),
          body: data
        })
        .then(res => { 
            if(res.ok === true){
              this.showErrorComments(postCommentID, '');
            }
            else{
              this.showErrorComments(postCommentID, 'error');
            }
            this.renderCommentBox(postCommentID);
          })
        
      }

      
  }



  handleLikes(e){
    e.preventDefault();
    const id = e.target.id;
    if(this.updateLikedList(id))
      return;
    
    let likecount = parseInt(e.target.getAttribute('data-likes'));
    likecount = parseInt(likecount+1);
    console.log(likecount);
    if(likecount > 0 ){
      // update likes on server.
      console.log('likecount');
      
      let username = 'open-data';
      let password = 'open_data';
      
      let headers = new Headers();

      headers.append('Access-Control-Allow-Origin', 'http://localhost:3333');
      headers.append('Access-Control-Allow-Credentials', 'true');

      var formData = new FormData();
      formData.append('postID', id);
      formData.append('meta_key', 'likes');
      formData.append('meta_value', likecount);
      let url = constants.metaUpdate;
      //url =     'http://localhost/zupress/open-data/wp-json/zutheme/v1/latest-posts/1'
      // http://localhost/zupress/open-data/wp-json/zutheme/v1/update-posts-meta/

      fetch(url, {
        method: 'POST',
        headers: new Headers({
          "Authorization": "Basic " + base64.encode(username + ":" + password) 
         }),
        body: formData
      })
      .then(res => res.json())
      .then(json => {
        // console.log(json);
        if(json.success){
          console.log(json.data.new_data[0]);
          
          this.setState({ likesCount : json.data.new_data[0]}); 

          this.renderCommentBox(id);

        }
        else
        {
            this.showError(id);
        }
      })
    }

     

    
  }

  render() {
    return (
      <div className="rate-actions">
        <ul className="likes" key={this.props.postID}>
          <li>
            <a href="#" id={this.props.postID} data-likes={this.state.likesCount} onClick={this.handleLikes}>
              <em className="fa fa-thumbs-o-up" id={this.props.postID} data-likes={this.state.likesCount} onClick={this.handleLikes}></em>
            </a>
            <span>{this.state.likesCount}</span>
            
          </li>
          <li>
            <a className="external-link item-share addthis_button" target="_blank" 
               
              href="https://www.addthis.com/bookmark.php" title="" data-title=""><em className="fa fa-share"></em>
            </a>
          </li>
        </ul>
        <div className="comments-block">
            <div className="comments hidden" id={`comments_${this.props.postID}`} key={this.props.postID}>
                <textarea name="comment" rows="5" id={`txt_${this.props.postID}`} placeholder={constants['placeHolder_'+this.props.currentLang]}></textarea>
                <button name="postComment" data-id={this.props.postID} id={`btn_${this.props.postID}`} onClick={this.postComment}>Post</button>
              </div>
              <p className="comments-response hidden" id={`comments_response_${this.props.postID}`}></p>
          </div>
      </div>
    );
  }
}
