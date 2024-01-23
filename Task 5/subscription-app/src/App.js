
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
// import PrivateRoute from './PrivateRoute';
import Register from "./Components/Registration/Registration";
import Login from "./Components/Login/Login";
import Logout from "./Components/Login/Logout";
import ForgetPassword from "./Components/Login/ForgetPassword";
import Dashboard from './Components/Dashboard/Dashboard';
import PackageList from "./Components/Pacakge/PackageList";
import AddPackage from "./Components/Pacakge/AddPackage";
import EditPackage from "./Components/Pacakge/EditPackage";

function App() {
  return (
    <Router>
        <Routes>
          
          <Route path="/" element={<Login />}></Route>
          <Route path="/logout" element={<Logout />}></Route>
          <Route path="/forgot-password" element={<ForgetPassword />}></Route>
          {/* <Route path="/login" element={<Login setUserState={setUserState} />}></Route> */}

          <Route path="/register" element={<Register />}></Route>
          <Route path="/dashboard" element={<Dashboard/>}></Route>
          <Route path="/packagelist" element={<PackageList/>}></Route>
          <Route path="/addpackage" element={<AddPackage/>}></Route>
          <Route path="/editpackage/:id" element={<EditPackage/>}></Route>
        </Routes>
      </Router>
  );
}

export default App;
