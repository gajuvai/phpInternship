import React from 'react';
import { Route } from 'react-router-dom';

const PrivateRoute = ({ component: Component, fallback: Fallback, ...rest }) => {
  const isAuthenticated = !!localStorage.getItem('authToken');

  return (
    <Route
      {...rest}
      render={(props) => (isAuthenticated ? <Component {...props} /> : <Fallback {...props} />)}
    />
  );
};

export default PrivateRoute;
