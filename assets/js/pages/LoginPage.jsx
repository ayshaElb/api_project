import React, { useState } from 'react';
import axios from "axios";
import Field from '../components/forms/Field';

const LoginPage = (props) => {

    const [credentials, setCredentials] = useState({
        username: "",
        password: ""
    });

    const [error, setError] = useState("");

    const handleChange = (event) => {
        const value = event.currentTarget.value;
        const name = event.currentTarget.name;

        setCredentials({ ...credentials, [name]: value })
    };

    const handleSubmit = async event => {
        event.preventDefault();

        try {
            const token = await axios
                .post("http://127.0.0.1:8001/api/login_check", credentials)
                .then(response => response.data.token);
            
            setError("");
            // je stocke le token dans mon locale storage
            window.localStorage.setItem("authToken", token);
            // on previent Axios qu'on a maintenant un header par default sur toutes nos futures requetes HTTP
            axios.defaults.headers["Authorization"] = "Bearer " + token;

            //const data = await 
        } catch (error) {
            setError("Aucun compte ne possède cette adresse email ou alors les informations ne correspondent pas ")
        }
        console.log(credentials);
    };



    return (<>
        <h1> Connexion à l'application </h1>

        <form onSubmit={handleSubmit}>
            <Field label="Adresse email" name="username" value={credentials.username} onChange={handleChange} placeholder="Adresse email de connexion" error={error} />
                       
            <div className="form-group">
                <label htmlFor="password"> Mot de passe </label>
                <input
                    value={credentials.password}
                    onChange={handleChange}
                    type="password"
                    placeholder="Mot de passe "
                    name="password" id="password"
                    className="form-control" />
            </div>

            <div className="form-group">
                <button type="submit" className="btn btn-success">Je me connecte</button>
            </div>
        </form>
    </>);
}

export default LoginPage;