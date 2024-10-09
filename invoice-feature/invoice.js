function enumerateItemNumbers(){
    let itemNumbers=document.getElementsByClassName("itemNumber")
    for(let item=0; item<itemNumbers.length;item++){
        itemNumbers[item].innerHTML=(item+1).toString().padStart(2, '0')+":"
    }
}
function addItemToForm(){
    let template=document.getElementById("itemTemplate")
    let html = template.content.cloneNode(true)
    document.getElementById("invoiceItems").appendChild(html)
    //find delete button on newest item and add event listener to delete its parent
    let deleteButtons = document.getElementsByClassName("deleteItemButton")
    let deleteButton = deleteButtons[deleteButtons.length-1]
    deleteButton.addEventListener("click",(event)=>{
        //don't allow user to remove the only item
        if(document.getElementsByClassName("quantityInput").length>1){
            event.target.parentElement.remove()
            enumerateItemNumbers()
        }
    })
    //add event listener for changes on quantity and price
    let quantityInputs = document.getElementsByClassName("quantityInput")
    let priceInputs = document.getElementsByClassName("priceInput")
    
    quantityInputs[quantityInputs.length-1].addEventListener("input",computeCost)
    priceInputs[priceInputs.length-1].addEventListener("input",computeCost)
    enumerateItemNumbers()
}
function computeCost(){
    let cost=0
    let quantityInputs = document.getElementsByClassName("quantityInput")
    let priceInputs = document.getElementsByClassName("priceInput")
    for(let item=0; item<quantityInputs.length; item++){
        let quantity = parseInt(quantityInputs[item].value)
        let price = parseFloat(priceInputs[item].value)
        //if quantity and price are filled out add to total so we don't get NaN
        if (!isNaN(quantity)&&!isNaN(price)){
            cost+=quantity*price
        }
    }
    document.getElementById("invoicePriceDisplay").innerHTML=`Total : ${cost==0? "---":cost.toLocaleString("en-US",{
        style:"currency",
        currency:"usd"
    })}`
}
addItemToForm()