import React, {useState} from 'react'

import './product.scss'

export default function Product(props) {
    const [checked,setChecked] = useState(false)

    /*
        Method for receiving the function passed with props
    */

    const onCheckDelete = () =>{
        props.idCallback(props.product.id,!checked)
        setChecked(!checked)
    }

    /*
        Component for rendering different attribute types based on data from categories
    */

    const RenderAttribute = () =>{
        return (<div>{props.category.attrName}: {props.product.attribute} {props.category.hasOwnProperty('mUnits')?props.category.mUnits:""}</div>)
    }
    return (
        <div className={checked? "product-container checked" : "product-container"}>
            <input type="checkbox" className="delete-checkbox" onClick={onCheckDelete} name="checkbox" id="" />
            <div>{props.product.sku}</div>
            <div>{props.product.name}</div>
            <div>{props.product.price} $</div>
            <RenderAttribute/>
        </div>
    )
}
