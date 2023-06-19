<script type="text/javascript">
    let zipcodeElement = document.getElementById('{{ $postcodenlFields['postcodenl_zipcode'] ?? '' }}');
    let houseNumberElement = document.getElementById('{{ $postcodenlFields['postcodenl_house_number'] ?? '' }}');
    let houseNumberAdditionElement = document.getElementById('{{ $postcodenlFields['postcodenl_house_number_addition'] ?? '' }}');
    let streetElement = document.getElementById('{{ $postcodenlFields['postcodenl_street'] ?? '' }}');
    let cityElement = document.getElementById('{{ $postcodenlFields['postcodenl_city'] ?? '' }}');

    if(zipcodeElement && zipcodeElement.length !== 0){
        zipcodeElement.addEventListener('change', () => {
            window.getAddressFromPostcodeservice(zipcodeElement.value, houseNumberElement.value, houseNumberAdditionElement && houseNumberAdditionElement.value ? houseNumberAdditionElement.value : '');
        });
    }

    if(houseNumberElement && houseNumberElement.length !== 0) {
        houseNumberElement.addEventListener('change', () => {
            window.getAddressFromPostcodeservice(zipcodeElement.value, houseNumberElement.value, houseNumberAdditionElement && houseNumberAdditionElement.value ? houseNumberAdditionElement.value : '');
        });
    }

    if(houseNumberAdditionElement && houseNumberAdditionElement.length !== 0) {
        houseNumberAdditionElement.addEventListener('change', () => {
            window.getAddressFromPostcodeservice(zipcodeElement.value, houseNumberElement.value, houseNumberAdditionElement && houseNumberAdditionElement.value ? houseNumberAdditionElement.value : '');
        });
    }

    if (!window.getAddressFromPostcodeservice) {
        window.getAddressFromPostcodeservice = async function(zipcode, houseNumber, houseNumberAddition) {
            if (!zipcode || !houseNumber || streetElement.length === 0 || cityElement.length === 0) {
                return;
            }

            let xhr = new XMLHttpRequest();
            let data = {
                postcode: zipcode,
                house_number: houseNumber,
                house_number_addition: houseNumberAddition,
            };

            xhr.open('POST', '/api/postcodenl');
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.send(JSON.stringify(data));
            xhr.onload = function () {
                if (xhr.readyState !== xhr.DONE) {
                    return;
                }

                let responseData = JSON.parse(xhr.response);

                if (!responseData?.city || !responseData?.street) {
                    return;
                }

                streetElement.value = responseData.street
                cityElement.value = responseData.city
            };
        }
    }
</script>
