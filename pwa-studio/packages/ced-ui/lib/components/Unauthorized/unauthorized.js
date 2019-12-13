import React from 'react';
import defaultClasses from './unauthorized.css';
import { useEffect } from 'react';
import { Redirect } from '@magento/venia-drivers';

const Unauthorized = () => {

  if(localStorage.getItem('ced_license') != "" && localStorage.getItem('ced_license') != "novalue"){
         return <Redirect to="/" />;
    }
  useEffect(() => {
    var body = document.body;
    body.classList.add("unauth");
  });

    return (
      <div className={defaultClasses.wrapper}>
      	<p className={defaultClasses.number_title}>Oops!</p>
        <p className={defaultClasses.text_title}>Error 401 : Unauthorized Access</p>
        <p className={defaultClasses.sub_text + ' ' + defaultClasses.add_license}>{"Sorry, but you are not authorized to view this page.Add License at Magento Backend configuration to access this page."}</p>
      </div>
    );
};

export default Unauthorized;
