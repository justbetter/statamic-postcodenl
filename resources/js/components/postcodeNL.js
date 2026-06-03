export default (zipcodeField = 'zipcode', houseNumberField = 'house_number', houseNumberAdditionField = 'house_number_addition', streetField = 'street', cityField = 'city') => ({
    zipcodeField,
    houseNumberField,
    houseNumberAdditionField,
    streetField,
    cityField,

    init() {
        let watchedFields = new Set(
            [this.zipcodeField, this.houseNumberField, this.houseNumberAdditionField].filter(Boolean),
        )

        this.$el.addEventListener('change', (event) => {
            let target = event.target

            if (target?.id && watchedFields.has(target.id)) {
                this.lookup()
            }
        })
    },

    getElement(field) {
        if (!field) {
            return null
        }

        let selector = `#${CSS.escape(field)}`

        return this.$el.querySelector(selector) ?? window.document.getElementById(field)
    },

    getHouseNumberAddition(houseNumberAdditionElement) {
        if (houseNumberAdditionElement && houseNumberAdditionElement.value) {
            return houseNumberAdditionElement.value
        }

        return ''
    },

    clearAddress(streetElement, cityElement) {
        if (streetElement) {
            streetElement.value = ''
        }

        if (cityElement) {
            cityElement.value = ''
        }
    },

    setAddressState(streetElement, cityElement, disabled) {
        if (streetElement) {
            streetElement.disabled = disabled
        }

        if (cityElement) {
            cityElement.disabled = disabled
        }
    },

    async lookup() {
        let zipcodeElement = this.getElement(this.zipcodeField)
        let houseNumberElement = this.getElement(this.houseNumberField)
        let houseNumberAdditionElement = this.getElement(this.houseNumberAdditionField)
        let streetElement = this.getElement(this.streetField)
        let cityElement = this.getElement(this.cityField)

        let zipcode = zipcodeElement ? zipcodeElement.value : ''
        let houseNumber = houseNumberElement ? houseNumberElement.value : ''
        let houseNumberAddition = this.getHouseNumberAddition(houseNumberAdditionElement)

        let canLookup = Boolean(
            zipcode &&
            houseNumber &&
            streetElement &&
            cityElement
        )

        if (!canLookup) {
            return
        }

        this.setAddressState(streetElement, cityElement, true)

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

        this.setAddressState(streetElement, cityElement, false)

        if (responseData && responseData.city && responseData.street) {
            streetElement.value = responseData.street
            cityElement.value = responseData.city
        } else {
            this.clearAddress(streetElement, cityElement)
        }
    },
})
