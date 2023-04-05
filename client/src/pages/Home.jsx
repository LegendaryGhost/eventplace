import { Link } from 'react-router-dom';

const Home = () => {
    return <>
        <div className="row vh-100">
            <div className="col-12 col-lg-8">
                <nav className="navbar navbar-expand-lg bg-body-tertiary">
                    <div className="container-fluid">
                        <Link className="navbar-brand text-white" to="/Home">Navbar</Link>
                        <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span className="navbar-toggler-icon"></span>
                        </button>
                    <div className="collapse navbar-collapse" id="navbarNav">
                        <ul className="navbar-nav">
                            <li className="nav-item">
                                <Link className="nav-link text-white" aria-current="page" to="/Home">Home</Link>
                            </li>
                            <li className="nav-item">
                                <Link className="nav-link text-white" aria-current="page" to="/AboutUs">About us</Link>
                            </li>
                        </ul>
                    </div>
                    </div>
                </nav>
            </div>
            <div className="col-12 col-lg-4 bg-white">
                <nav>
                    <Link className="btn btn-light rounded rounded-pill" to="/Login" >Login</Link>
                    <Link className="btn btn-danger btn-pink rounded rounded-pill" to="/SignUp" >Sign up</Link>
                </nav>
            </div>
        </div>
    </>
};

export default Home;