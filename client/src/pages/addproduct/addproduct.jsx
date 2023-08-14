import React, { useEffect, useState } from 'react'
import './addproduct.scss'
import Header from '../../components/header/header'
import AttributeField, {ValidationMessage,CategoryValidationMessage} from './components/types'
import Selector from './components/selector'
import { useNavigate } from 'react-router-dom'
import { PRODUCT_ENDPOINT,CATEGORIES_ENDPOINT } from '../../apiEndpoints'

export default function Addproduct() {
    const [categories, setCategories] = useState([])
    const [currentCat, setCurrentCat] = useState("")
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState(false)
    const [formData, setFormData] = useState({sku:"",name:"",price:"",category:""})
    const [validation,setValidation] = useState()
    const [sendError, setSendError] = useState()

    const navigate = useNavigate()
    const redirect = (path) =>{
        navigate(path)
    }

    /*
        Form submit handler passed to the header component as a prop
    */

    const handleFormSubmit = (e) => {
        sendFormData()
        e.preventDefault();
    }

    /*
        Select change handler passed to the Selector component as a prop
    */

    const handleSelectChange = (event) => {
        setCurrentCat(event.target.value)
        setFormData({ ...formData, category: event.target.value })
    }

    /*
        Method for sending the form data 
    */

    const sendFormData = () => {
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        }
        fetch(PRODUCT_ENDPOINT, requestOptions)
            .then(response => {
                if(response.status === 422){
                    console.log("Invalid form data, please enter valid values!")
                }
                if(response.ok){
                    redirect("/")
                }
                return response.json()
            })
            .then(data => {
                if(data.status==="invalid"){
                    setValidation(data)
                }}   
            )
            .catch(error => {setSendError(error)})
    }

     /*
        Method for fetching the categories 
    */

    const fetchCategories = () => {
        fetch(CATEGORIES_ENDPOINT)
            .then(res => {
                if (res.ok) {
                    return res.json()
                }
            })
            .then(jsonData => {
                setCategories(jsonData);
            })
            .catch(error => {
                console.log("Error fetching data: ", error)
                setError(true)
            })
            .finally(() => {
                setLoading(false)
            })
    }
    useEffect(() => {
        fetchCategories()
    }, [])

    

    return (
        <div className="addproduct-container">
            <Header type="add" />
            <div className="form-container">
                <form onSubmit={(e)=>handleFormSubmit(e)} action="" id="product_form">
                    <div className="col col-one">
                        <div className="form-group">
                            <div className="label-container">
                                <label htmlFor="sku">SKU</label>
                            </div>
                        <input required value={formData.sku} onChange={(e) => {
                            setFormData({...formData,sku:e.target.value})
                            }} id="sku" name="sku" type="text" />
                        <ValidationMessage validation={validation} field="sku"/>
                        </div>
                        <div className="form-group">
                            <div className="label-container">
                                <label htmlFor="name">Name</label>
                            </div>
                            <input required value={formData.name} onChange={(e) => setFormData({...formData,name:e.target.value})} id="name" name="name" type="text" />
                            <ValidationMessage validation={validation} field="name"/>
                        </div>
                        <div className="form-group">
                            <div className="label-container">
                                <label htmlFor="price">Price($)</label>
                            </div>
                            <input required value={formData.price} onChange={(e) => setFormData({...formData,price:e.target.value})} id="price" name="price" type="text" />
                            <ValidationMessage validation={validation} field="price"/>
                        </div>
                        <Selector handleChange={handleSelectChange} loading={loading} error={error} categories={categories} currentCat={currentCat} formData={formData}/>
                        <CategoryValidationMessage validation={validation} field="category"/>
                    </div>
                    <div className="col col-two">
                        <AttributeField validation={validation} setCurrentCat={setCurrentCat} currentCat={currentCat} setFormData={setFormData} formData={formData}/>
                    </div>

                </form>
            </div>
        </div>
    )
}
