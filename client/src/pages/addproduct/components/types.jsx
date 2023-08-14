import React from 'react'

/*
    Attribute field specific to each product type
    It is rendered based on the currently selected category
*/

export default function AttributeField(props) {
    switch (props.currentCat) {
        case "Book":
            return (<BookForm validation={props.validation} setFormData={props.setFormData} formData={props.formData} />)
            break;
        case "Furniture":
            return (<FurnitureForm validation={props.validation} setFormData={props.setFormData} formData={props.formData} />)
            break;
        case "DVD":
            return (<DVDForm validation={props.validation} setFormData={props.setFormData} formData={props.formData} />)
            break;
        default:
            return (
                <div className="form-group">Select a product type</div>
            )
            break;
    }
}

/*
    Attribute field specific to Book product type
*/

export function BookForm(props) {
    return (
        <div className="attribute">
            <div className="form-group">
                <div className="label-container">
                    <label htmlFor="weight">Weight(KG)</label>
                </div>
                <input value={props.formData.weight} onChange={(e) => {
                    props.setFormData({ ...props.formData, weight: e.target.value })
                }} required id="weight" name="weight" type="text" />
                <ValidationMessage validation={props.validation} field="attribute"/>
            </div>
            <div className="form-group description">
                <p>Please provide the weight of the book in KG</p>
            </div>
        </div>
    )
}

/*
    Attribute field specific to DVD product type
*/

export function DVDForm(props) {
    return (
        <div className="attribute">
            <div className="form-group">
                <div className="label-container">
                    <label htmlFor="size">Size(MB)</label>
                </div>
                <input value={props.formData.size} onChange={(e) => {
                    props.setFormData({ ...props.formData, size: e.target.value })
                }} required id="size" name="size" type="text" />
                <ValidationMessage validation={props.validation} field="attribute"/>
            </div>
            <div className="form-group description">
                <p>Please provide the size of the dvd in MB</p>
            </div>
        </div>
    )
}

/*
    Attribute field specific to Furniture product type
*/

export function FurnitureForm(props) {
    return (
        <div className="attribute">
            <div className="form-group">
                <div className="label-container">
                    <label htmlFor="height">Height(CM)</label>
                </div>
                <input value={props.formData.height} required onChange={(e) => props.setFormData({ ...props.formData, height: e.target.value })} id="height" name="height" type="text" />
                <AttributeValidationMessage validation={props.validation} field="height"/>
            </div>
            <div className="form-group">
                <div className="label-container">
                    <label htmlFor="width">Width(CM)</label>
                </div>
                <input value={props.formData.width} required onChange={(e) => props.setFormData({ ...props.formData, width: e.target.value })} id="width" name="width" type="text" />
                <AttributeValidationMessage validation={props.validation} field="width"/>
            </div>
            <div className="form-group">
                <div className="label-container">
                    <label htmlFor="length">Length(CM)</label>
                </div>
                <input value={props.formData.length} required onChange={(e) => props.setFormData({ ...props.formData, length: e.target.value })} id="length" name="length" type="text" />
                <AttributeValidationMessage validation={props.validation} field="length"/>
            </div>
            <div className="form-group description">
                <p>Please provide dimensions in HxWxL format</p>
            </div>
        </div>
    )
}

/*
    Validation message component
    If the form data was invalid, the first message will be shown next to the input field
*/

export function ValidationMessage(props) {
    if(props.validation&&props.validation.status==="invalid" && (props.field in props.validation)){
        return (
            <div className="validation">
                {props.validation[props.field][Object.keys(props.validation[props.field])[0]]}!
            </div>
        )
    }else{
        return <></>
    }
   
}

/*
    Validation message component
    If the attribute was invalid, the first message will be shown next to each of the input fields
*/

export function CategoryValidationMessage(props) {
    if(props.validation&&props.validation.status==="invalid" && (props.field in props.validation)){
        return (
            <div className="validation">
                {props.validation[props.field]}!
            </div>
        )
    }else{
        return <></>
    }
   
}
export function AttributeValidationMessage(props) {
    if(props.validation && props.validation.status==="invalid" && props.validation.attribute){
        if(props.field in props.validation.attribute){
            return (
                <div className="validation">
                    {props.validation.attribute[props.field][Object.keys(props.validation.attribute[props.field])[0]]}!
                </div>
            )
        }else{
            return <></>
        }
    }else{
        return <></>
    }
   
}
