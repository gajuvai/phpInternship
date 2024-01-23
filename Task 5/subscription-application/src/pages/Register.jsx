import React, { useState } from 'react';
// import { Link } from "react-router-dom";

const Register = () => {
    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [address, setAddress] = useState("");
    const [contact, setContact] = useState("");
    const [password, setPassword] = useState("");
    const [password_confirmation, setRePassword] = useState("");
    const [errorMessages, setErrorMessages] = useState([]);

    async function handleRegister() {
        let item = { name, email, address, contact, password, password_confirmation };

        let result = await fetch("http://127.0.0.1:8000/api/user/register", {
            method: 'POST',
            body: JSON.stringify(item),
            headers: {
                "Content-Type": 'application/json',
                "Accept": 'application/json'
            }
        });

        result = await result.json();

        if (result.status === 1 && result.status === 0) {
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
                <h1>Register Form</h1>
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
                        type='text'
                        id="floatingName"
                        className={`form-control ${hasError('name') ? 'border-danger' : ''}`}
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                        placeholder='Full Name'
                    />
                    <label htmlFor="floatingName">Full Name</label>
                    {hasError('name') && (
                        <div className="flex flex-col">
                            <small className="text-danger">{errorMessages.name}</small>
                        </div>
                    )}
                </div>
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
                        type='text'
                        id="floatingAddress"
                        className={`form-control ${hasError('address') ? 'border-danger' : ''}`}
                        value={address}
                        onChange={(e) => setAddress(e.target.value)}
                        placeholder='Full Address'
                    />
                    <label htmlFor="floatingAddress">Full Address</label>
                    {hasError('address') && (
                        <div className="flex flex-col">
                            <small className="text-danger">{errorMessages.address}</small>
                        </div>
                    )}
                </div>
                <br />

                <div className="form-floating">
                    <input
                        type='text'
                        id="floatingContact"
                        className={`form-control ${hasError('contact') ? 'border-danger' : ''}`}
                        value={contact}
                        onChange={(e) => setContact(e.target.value)}
                        placeholder='Contact Number'
                    />
                    <label htmlFor="floatingContact">Contact Number</label>
                    {hasError('contact') && (
                        <div className="flex flex-col">
                            <small className="text-danger">{errorMessages.contact}</small>
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

                <div className="form-floating">
                    <input
                        type='password'
                        id="floatingRePassword"
                        className={`form-control ${hasError('password_confirmation') ? 'border-danger' : ''}`}
                        value={password_confirmation}
                        onChange={(e) => setRePassword(e.target.value)}
                        placeholder='Re Password'
                    />
                    <label htmlFor="floatingRePassword">Re Password</label>
                    {hasError('password_confirmation') && (
                        <div className="flex flex-col">
                            <small className="text-danger">{errorMessages.password_confirmation}</small>
                        </div>
                    )}
                </div>
                <br />

                <button className='btn btn-primary' onClick={handleRegister}>Sign Up</button>
                <br/>

                <a href="register.html" class="text-center">I already have a membership</a>
            </div>
        </div>
    );
}

export default Register;
