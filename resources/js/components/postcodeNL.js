export default (zipcodeField = 'zipcode', houseNumberField = 'house_number', houseNumberAdditionField = 'house_number_addition', streetField = 'street', cityField = 'city') => ({
    zipcodeField,
    houseNumberField,
    houseNumberAdditionField,
    streetField,
    cityField,
    zipcodeElement: null,
    houseNumberElement: null,
    houseNumberAdditionElement: null,
    streetElement: null,
    cityElement: null,

    init() {
        this.zipcodeElement = this.getElement(this.zipcodeField)
        this.houseNumberElement = this.getElement(this.houseNumberField)
        this.houseNumberAdditionElement = this.getElement(this.houseNumberAdditionField)
        this.streetElement = this.getElement(this.streetField)
        this.cityElement = this.getElement(this.cityField)

        this.bindChange(this.zipcodeElement)
        this.bindChange(this.houseNumberElement)
        this.bindChange(this.houseNumberAdditionElement)
    },

    getElement(field) {
        let element = null

        if (field) {
            element = document.getElementById(field)
        }

        return element
    },

    bindChange(element) {
        if (element) {
            element.addEventListener('change', () => {
                this.lookup()
            })
        }
    },

    getHouseNumberAddition() {
        let houseNumberAddition = ''

        if (this.houseNumberAdditionElement && this.houseNumberAdditionElement.value) {
            houseNumberAddition = this.houseNumberAdditionElement.value
        }

        return houseNumberAddition
    },

    clearAddress() {
        if (this.streetElement) {
            this.streetElement.value = ''
        }

        if (this.cityElement) {
            this.cityElement.value = ''
        }
    },

    setAddressState(disabled) {
        if (this.streetElement) {
            this.streetElement.disabled = disabled
        }

        if (this.cityElement) {
            this.cityElement.disabled = disabled
        }
    },

    async lookup() {
        let zipcode = this.zipcodeElement ? this.zipcodeElement.value : ''
        let houseNumber = this.houseNumberElement ? this.houseNumberElement.value : ''
        let houseNumberAddition = this.getHouseNumberAddition()

        let canLookup = Boolean(
            zipcode &&
            houseNumber &&
            this.streetElement &&
            this.cityElement
        )

        if (canLookup) {
            this.setAddressState(true)

            let responseData = null

            try {
                let response = await fetch('/api/postcodenl', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        postcode: zipcode,
                        house_number: houseNumber,
                        house_number_addition: houseNumberAddition,
                    }),
                })

                let responseText = await response.text()

                responseData = JSON.parse(responseText)
            } catch (error) {
                console.error(error)
                responseData = null
            }

            this.setAddressState(false)

            if (responseData && responseData.city && responseData.street) {
                this.streetElement.value = responseData.street
                this.cityElement.value = responseData.city
            } else {
                this.clearAddress()
            }
        }
    },
})