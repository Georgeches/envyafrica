function handleCardNumberChange(e){
    const inputNumber = e.target.value.replace(/\s+/g, '');

    if (/^[0-9 ]*$/.test(inputNumber)) {
        if (inputNumber.length <= 16) {
            let formattedNumber = '';
            for (let i = 0; i < inputNumber.length; i += 4) {
                formattedNumber += inputNumber.substr(i, 4) + ' ';
            }
            setCardNumber(formattedNumber.trim());
        }
    }
};

function handleExpirationChange(e){
    const inputExpiration = e.target.value;

    if (inputExpiration.length <= 5) {
        setCardExpiration(inputExpiration);
    }
};

function handleChangeCvv(e){
    const inputCvv = e.target.value;

    if (inputCvv.length <= 3) {
        setCvv(inputCvv);
    }
    console.log(cardCvv)
};