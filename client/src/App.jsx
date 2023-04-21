import './App.css';
import { createBrowserRouter, RouterProvider } from "react-router-dom";
import Home from './pages/Home';
import Login from './pages/Login/Login';
import SignUp from './pages/SignUp/SignUp';
const router = createBrowserRouter([
  { path: "/login", element: <Login /> },
  { path: "/signup", element: <SignUp /> },
  { path: "*", element: <Home /> }
]);

const App = () => {
  return <div className="container">
    <RouterProvider router={router} />
  </div>;
};

export default App;
