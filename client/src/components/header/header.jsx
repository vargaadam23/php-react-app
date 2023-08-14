import React, {useState,useEffect} from 'react'
import './header.scss'
import { useNavigate } from 'react-router-dom'

export default function Header(props) {
    const [type,setType] = useState({renderer:()=>{
        return (<div>Loading...</div>)}
    })

    /*
        Navigation methods
    */

    const navigate = useNavigate()
    const redirect = (path) =>{
        navigate(path)
    }

    useEffect(()=>{
        renderButtons();
    },[])

    /*
        Render title and buttons based on props passed to component
    */

    const renderButtons = () => {
        if(props.type === "products"){
            setType({title:"Products page",renderer:renderProducts})
        }else{
            if(props.type === "add"){
                setType({title:"Products Add",renderer:renderAdd})
            }else{
                setType({title:"Menu", renderer:renderDefault})
            }
        }
    }

    /*
        Render default menu
    */

    const renderDefault = () =>{
        return(
            <div className="buttons-container container">
                    <button onClick={()=>redirect('/add-product')} className="btn">
                        ADD PAGE
                    </button>
                    <button onClick={()=>redirect('/')} className="btn">
                        PRODUCTS
                    </button>
                </div> 
        )
    }

    /*
        Render product add page menu
    */

    const renderAdd = () =>{
        return(
            <div className="buttons-container container">
                    <button form="product_form" type='submit' className="btn">
                        Save
                    </button>
                    <button className="btn" onClick={()=>redirect('/')}>
                        CANCEL
                    </button>
                </div> 
        )
    }

    /*
        Render products page menu
    */

    const renderProducts = () =>{
        return(
            <div className="buttons-container container">
                    <button onClick={()=>redirect('/add-product')} className="btn">
                        ADD
                    </button>
                    <button className="btn" onClick={()=>props.handleDelete()} id="delete-product-btn">
                        MASS DELETE
                    </button>
                </div> 
        )
    }

    /*
        Functional component main return
    */

    return (
        <div className="header-container">
            <div className="header">
                <div className="title-container container">
                    <h3>{type.title}</h3>
                </div>
                {type.renderer()}
            </div>
            <hr />
        </div>
    )
}
