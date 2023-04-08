import "./SignUp.css"
const SignUp = () => {
    return  <form className="center">
    <h2>Sign up</h2>
    <label htmlFor="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required/>
    
    <label Htmlfor="email">Email :</label>
    <input type="email" id="email" name="email" required/>
    
    <label Htmlfor="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required/>

   <label Htmlfor="buyer">buyer</label>
   <input type="radio" name="buyer" id="buyer" required/>

   <label Htmlfor="creator">creator</label>
   <input type="radio" name="creator" id="creator" required/>
    
    <button type="submit">S'inscrire</button>
  </form>;

}
export default SignUp;