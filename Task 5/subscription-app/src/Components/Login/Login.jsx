import React, { useState } from 'react';
import axios from 'axios';
import { Link, useNavigate} from 'react-router-dom';

const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [errorMessages, setErrorMessages] = useState([]);
    // const history = useHistory();
    const navigate = useNavigate();

    const handleLogin = async () => {
        try {
            const response = await axios.post("http://127.0.0.1:8000/api/user/login", {
                email,
                password,
            });

            // For example, redirect to dashboard if login is successful
            if (response.data.status === 1) {
                // Redirect logic here
                console.log("Redirect to dashboard");
                const token = response.data.token;
                localStorage.setItem('authToken', token);
                
                // history.push('/dashboard');
                navigate('/dashboard');
            }

        } catch (error) {
            // Handle validation errors or other errors
            if (error.response && error.response.data) {
                setErrorMessages([error.response.data.message]);
            } else {
                console.error("Error logging in:", error.message);
            }
        }
    };

    const hasError = (fieldName) => errorMessages[fieldName] !== undefined;

    return (
        <div className="container p-3">
            <div className="col-md-6 offset-md-3">
                <div className="card">
                    <div className="card-body">
                        <h1 className="card-title text-center">Login Form</h1>
                        <br />

                        {/* Display validation errors */}
                        {errorMessages.length > 0 && (
                            <div className="alert alert-danger">
                                <ul>
                                    {errorMessages.map((error, index) => (
                                        <li key={index}>{error}</li>
                                    ))}
                                </ul>
                            </div>
                        )}

                        <div className="mb-3">
                            <label htmlFor="email" className="form-label">Email Address</label>
                            <input type="email" className={`form-control ${hasError('email') ? 'is-invalid' : ''}`} id="email" value={email} onChange={(e) => setEmail(e.target.value)} />
                            {hasError('email') && (
                                <div className="invalid-feedback">{errorMessages[0]}</div>
                            )}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="password" className="form-label">Password</label>
                            <input type="password" className={`form-control ${hasError('password') ? 'is-invalid' : ''}`} id="password" value={password} onChange={(e) => setPassword(e.target.value)} />
                            {hasError('password') && (
                                <div className="invalid-feedback">{errorMessages[0]}</div>
                            )}
                        </div>

                        <button className='btn btn-primary' onClick={handleLogin}>Login</button>
                        <br />
                        <br />
                        <p className="text-center">
                            Don't have an account? <Link to="/register">Register here</Link>.<br />
                            Forgot your password? <Link to="/forgot-password">Reset it here</Link>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Login;
