import React, { useState, useEffect } from 'react'
import Header from '../../components/header/header'
import Product from './components/product/product'
import './products.scss'
import { PRODUCT_ENDPOINT,CATEGORIES_ENDPOINT } from '../../apiEndpoints'

export default function Products() {
    const [products,setProducts] = useState({})
    const [categories,setCategories] = useState({})
    const [deleteArray,setDeleteArray] = useState([]);

    const [loading,setLoading] = useState(true)
    const [loadingCat,setLoadingCat] = useState(true)

    const [error,setError] = useState(false)
    const [errorCat,setErrorCat] = useState(false)
    const [errorDel,setErrorDel] = useState()

     /*
        Method for deleting products
    */

    const deleteProducts = () =>{
        const requestOptions = {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(deleteArray)
        }
        fetch(PRODUCT_ENDPOINT, requestOptions)
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => {
                console.log(error)
                setErrorDel(error)
            })
            .finally(()=>{
                setDeleteArray([])
                fetchProducts();
            })
    }

    /*
        Method for fetching categories
    */

    const fetchCategories = () =>{
        fetch(CATEGORIES_ENDPOINT)
        .then(res => {
            if(res.ok){
                return res.json()
            }
        })
        .then(jsonData =>{
            setCategories(jsonData);
        })
        .catch(error => {
            console.log("Error fetching data: ",error)
            setErrorCat(true)
        })
        .finally(()=>{
            setLoadingCat(false)
        })
    }

     /*
        Method for fetching all the products 
    */

    const fetchProducts = () =>{
        fetch(PRODUCT_ENDPOINT)
        .then(res => {
            if(res.ok){
                return res.json()
            }
        })
        .then(jsonData =>{
            setProducts(jsonData);
        })
        .catch(error => {
            console.log("Error fetching data: ",error)
            setError(true)
        })
        .finally(()=>{
            setLoading(false)
        })
    }

    /*
        Method for retrying if an error occured or if no products show up
    */

    const retry = () =>{
        setLoading(true)
        setError(false)
        fetchProducts() 
    }

    useEffect(()=>{
        fetchProducts()
        fetchCategories()
    },[])

     /*
       Component for rendering product component, data loading and errors
    */

    const RenderProducts = () =>{
        if(loading||loadingCat){
            return(
                <div className="loading">Loading data...</div>
                
            )
        }else{
            if(error||errorCat){
                return(
                    <div className="loading">Error, could not fetch data from api <br /><br /><button className="btn" onClick={retry}><i className="fas fa-sync"></i> Retry</button></div>
                )
            }else{
                if(Object.keys(products).length === 0){
                    return (<div className="loading">No products were uploaded yet to our database, please add products using the <b>ADD</b> button <br /><br /><button className="btn" onClick={retry}><i className="fas fa-sync"></i> Retry</button></div>)
                }else{
                    return products.map((product)=>{
                         var category = categories.find(category => category.category === product.category)
                        return(
                            <Product key={product.id} category={category} product={product} idCallback={handleDeleteCheck}/>
                        )
                    })
                }
            }
        }
    }

     /*
        Method passsed as prop to Product component for handling checkboxes 
    */

    const handleDeleteCheck = (id,checked) =>{
        var array = deleteArray
        if(checked){
            array.push(id)
            setDeleteArray(array)
        }   
        else{
            var index = array.indexOf(id)
            array.splice(index,1)
            setDeleteArray(array)
        }
        console.log(deleteArray)
    }

    const DeleteErrors = () =>{
        if(errorDel){
            return (
                <div className="validation">
                    {errorDel}
                </div>
            )
        }
        return (<></>)
    }



    return (
        <div className="products-container">
            <Header type="products" handleDelete = {deleteProducts}/>
            <div className="items-container">
                <DeleteErrors/>
                <RenderProducts/>
            </div>
        </div>
    )
}
