import React from 'react';
import { Link } from 'react-router-dom';

const Logout = () => {

  localStorage.removeItem('authToken');

  return (
    <div className="container p-3">
      <div className="col-md-6 offset-md-3">
        <h1>Logout</h1>
        <p>You have been logged out successfully.</p>
        <Link className="btn btn-primary" to={"/"}>Continue </Link>
      </div>
    </div>
  );
};

export default Logout;
