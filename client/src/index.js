import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Routes, Route, Link } from "react-router-dom";
import Products from './pages/products/products'
import Footer from './components/footer/footer';
import Addproduct from './pages/addproduct/addproduct';
import './global.css'


ReactDOM.render(
  <Router>
    <React.StrictMode>
      <Routes>
        <Route exact path="/" element={<Products/>}/>
      </Routes>
      <Routes>
        <Route exact path="/add-product" element={<Addproduct/>}/>
      </Routes>
    <Footer/>
    </React.StrictMode>
  </Router>,
  document.getElementById('root')
);