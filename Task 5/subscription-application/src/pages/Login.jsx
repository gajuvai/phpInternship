import React, { useState } from 'react';
// import { useHistory } from 'react-router-dom';

const Login = () => {

    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [errorMessages, setErrorMessages] = useState([]);
    // const history = useHistory();

    async function handleLogin() {
        let item = { email, password };

        let result = await fetch("http://127.0.0.1:8000/api/user/login", {
            method: 'POST',
            body: JSON.stringify(item),
            headers: {
                "Content-Type": 'application/json',
                "Accept": 'application/json'
            }
        });

        result = await result.json();

        if (result.status === 1) {
            // Registration successful
            setErrorMessages([]);
        } else {
            // Handle validation errors
            setErrorMessages(result.errors);
        }
    }
    const hasError = (fieldName) => errorMessages[fieldName] !== undefined;

  return (
    <div className="container p-3 ">
            <div className="col-sm-6 offset-sm-3 ">
                <h1>Login Form</h1>
                <br />

                {/* {errorMessages.length > 0 && (
                    <div className="alert alert-danger">
                        <ul>
                            {errorMessages.map((error, index) => (
                                <li key={index}>{error}</li>
                            ))}
                        </ul>
                    </div>
                )} */}

                <br />

                <div className="form-floating">
                    <input
                        type='email'
                        id="floatingEmail"
                        className={`form-control ${hasError('email') ? 'border-danger' : ''}`}
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        placeholder='Email'
                    />
                    <label htmlFor="floatingEmail">Email Address</label>
                    {hasError('email') && (
                        <div className="flex flex-col">
                            <small className="text-danger">{errorMessages.email}</small>
                        </div>
                    )}
                </div>
                <br />

                <div className="form-floating">
                    <input
                        type='password'
                        id="floatingPassword"
                        className={`form-control ${hasError('password') ? 'border-danger' : ''}`}
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        placeholder='Password'
                    />
                    <label htmlFor="floatingPassword">Password</label>
                    {hasError('password') && (
                        <div className="flex flex-col">
                            <small className="text-danger">{errorMessages.password}</small>
                        </div>
                    )}
                </div>
                <br />

                <button className='btn btn-primary' onClick={handleLogin}>Login</button>
                <br/>
                <br/>
                <a href="register.html" class="text-center">I forgot my password</a> <br/><br/>
                <a href="register.html" class="text-center">Register a new membership</a>
            </div>
        </div>
  );
}

export default Login;
