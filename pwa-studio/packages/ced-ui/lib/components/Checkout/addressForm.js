import React from 'react';
import { useState } from 'react';

import { Form } from 'informed';
import { array, bool, func, object, shape, string } from 'prop-types';

import { mergeClasses } from '../../classify';
import Button from '../Button';
import defaultClasses from './addressForm.css';
import {
    validateEmail,
    isRequired,
    hasLengthExactly,
    validateRegionCode
} from '../../util/formValidators';
import combine from '../../util/combineValidators';
import TextInput from '../TextInput';
import Field from '../Field';
import Select from '../Select';
import { useAddressForm } from '@magento/peregrine/lib/talons/Checkout/useAddressForm';

const fields = [
    'city',
    'email',
    'firstname',
    'lastname',
    'postcode',
    'region_code',
    'street',
    'telephone'
];

const AddressForm = props => {
    const { countries, error, isSubmitting, onCancel, onSubmit } = props;
     
    const [shipCountry, setShipCountry] = useState('US');

    const showRegion = () => {
        if (
            document.getElementById('country_id') &&
            shipCountry != document.getElementById('country_id').value
        ) {
            var sel = document.getElementById('country_id').value;
            setShipCountry(sel);
        }
    };

    let showRegionId = false;
    let selectableCountries = [];
    let selectableState = [];
    
    if (typeof countries != 'undefined' &&  countries !=null && countries.length) {
        {
            countries.map((value, index) => {
                selectableCountries[index] = {
                    label: value.full_name_english,
                    value: value.id
                };
                if (value.id == shipCountry) {
                    if (typeof value.available_regions != 'undefined') {
                        showRegionId = true;
                        selectableState = value.available_regions.map(
                            ({ id, name }) => ({
                                label: name,
                                value: id
                            })
                        );
                    } else {
                        showRegionId = false;
                        selectableState = [];
                    }
                }
            });
        }
    } else {
        selectableCountries = [];
    }
    const talonProps = useAddressForm({
        fields,
        initialValues: props.initialValues,
        onCancel,
        onSubmit
    });

    const { handleCancel, handleSubmit, initialValues } = talonProps;

    const classes = mergeClasses(defaultClasses, props.classes);
    return (
        <Form
            className={classes.root}
            initialValues={initialValues}
            onSubmit={handleSubmit}
        >
            <div className={classes.body}>
                <h2 className={classes.heading}>Shipping Address</h2>
                <div className={classes.validationMessage}>{error}</div>
                <div className={classes.firstname}>
                    <Field id={classes.firstname} label="First Name">
                        <TextInput
                            id={classes.firstname}
                            field="firstname"
                            validate={isRequired}
                        />
                    </Field>
                </div>
                <div className={classes.lastname}>
                    <Field id={classes.lastname} label="Last Name">
                        <TextInput
                            id={classes.lastname}
                            field="lastname"
                            validate={isRequired}
                        />
                    </Field>
                </div>
                <div className={classes.email}>
                    <Field id={classes.email} label="Email">
                        <TextInput
                            id={classes.email}
                            field="email"
                            validate={combine([isRequired, validateEmail])}
                        />
                    </Field>
                </div>
                <div className={classes.country}>
                    <Field label="Country">
                        <Select
                            id={'country_id'}
                            field="country_id"
                            initialValue={'US'}
                            items={selectableCountries}
                            onChange={showRegion}
                        />
                    </Field>
                </div>
                {selectableState.length != 0 && (
                    <div className={classes.region_id}>
                        <Field label="State">
                            <Select
                                id={'region_id'}
                                field="region_id"
                                initialValue={1}
                                items={selectableState}
                            />
                        </Field>
                    </div>
                )}
                {!selectableState.length && (
                    <div className={classes.region}>
                        <Field label="State">
                            <TextInput id={classes.region} field="region" />
                        </Field>
                    </div>
                )}
                <div className={classes.street0}>
                    <Field id={classes.street0} label="Street">
                        <TextInput
                            id={classes.street0}
                            field="street[0]"
                            validate={isRequired}
                        />
                    </Field>
                </div>
                <div className={classes.city}>
                    <Field id={classes.city} label="City">
                        <TextInput
                            id={classes.city}
                            field="city"
                            validate={isRequired}
                        />
                    </Field>
                </div>

                <div className={classes.postcode}>
                    <Field id={classes.postcode} label="ZIP">
                        <TextInput
                            id={classes.postcode}
                            field="postcode"
                            validate={isRequired}
                        />
                    </Field>
                </div>
                <div className={classes.telephone}>
                    <Field id={classes.telephone} label="Phone">
                        <TextInput
                            id={classes.telephone}
                            field="telephone"
                            validate={isRequired}
                        />
                    </Field>
                </div>
            </div>
            <div className={classes.footer}>
                <Button onClick={handleCancel}>Cancel</Button>
                <Button type="submit" priority="high" disabled={isSubmitting}>
                    Use Address
                </Button>
            </div>
        </Form>
    );
};

AddressForm.propTypes = {
    onCancel: func.isRequired,
    classes: shape({
        body: string,
        button: string,
        city: string,
        email: string,
        firstname: string,
        footer: string,
        heading: string,
        lastname: string,
        postcode: string,
        root: string,
        region_code: string,
        street0: string,
        telephone: string,
        validation: string
    }),
    countries: array,
    error: string,
    initialValues: object,
    isSubmitting: bool,
    onSubmit: func.isRequired
};

AddressForm.defaultProps = {
    initialValues: {}
};

export default AddressForm;

/*
const mockAddress = {
    country_id: 'US',
    firstname: 'Veronica',
    lastname: 'Costello',
    street: ['6146 Honey Bluff Parkway'],
    city: 'Calder',
    postcode: '49628-7978',
    region_id: 33,
    region_code: 'MI',
    region: 'Michigan',
    telephone: '(555) 229-3326',
    email: 'veronica@example.com'
};
*/
