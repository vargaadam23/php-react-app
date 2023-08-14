import React from 'react'

/*
    Type selector component
*/

export default function Selector(props) {
    if (props.loading) {
        return (
            <div className="form-group">
                Loading product categories...
            </div>
        )
    } else {
        if (props.error) {
            return (
                <div className="form-group">
                    Could not load categories from api!
                </div>
            )
        } else {
            return (
                <div className="form-group selector">
                    <div className="label-container">
                        <label htmlFor="productType">Select the type of the product</label>
                    </div>
                    <select id="productType" defaultValue={"0"} onChange={(event) => {
                        props.handleChange(event)
                        
                    }} name="productType" id="productType">
                        <option disabled value="0"> -- select a product type -- </option>
                        <Options categories={props.categories} />
                    </select>

                </div>
            )
        }
    }
}

/*
    Options component
*/

export function Options(props) {
    return props.categories.map(category => {
        return (
            <option key={category.category} value={category.category}>{category.category}</option>
        )
    })
}