import "./Login.css"

const Login = () => {
    return <form className="center">
    <h2>Logins</h2>
    <label htmlFor="nom">Name :</label>
    <input type="text" id="nom" name="nom" required/>
    
    <label Htmlfor="email">Email :</label>
    <input type="email" id="email" name="email" required/>
    
    <label Htmlfor="password">Password :</label>
    <input type="password" id="password" name="password" required/>
    
    <button type="submit">Log In</button>
  </form>;
}
export default Login; 