import React from 'react';
import { shape, string } from 'prop-types';

import { mergeClasses } from '../../classify';
import defaultClasses from './home.css';
import { Form } from 'informed';
import Button from '../Button';
import Field from '../Field';
import TextInput from '../TextInput';
import TextArea from '../TextArea';
import { useContactUs } from '@magento/peregrine/lib/talons/Home/useHome';
import { isRequired, validateEmail } from '../../util/formValidators';
import combine from '../../util/combineValidators';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faPhoneAlt, faEnvelope } from '@fortawesome/free-solid-svg-icons';

const Contact = props => {
    const classes = mergeClasses(defaultClasses, props.classes);

    const talonProps = useContactUs();
    const { formRef, handleSubmit, responseData } = talonProps;
    let errorMessage = '';
    let successMessage = '';
    if (typeof responseData != 'undefined') {
        if (!responseData.status) {
            errorMessage = responseData.message;
        }
        successMessage = responseData.message;
    }

    return (
        <div className={classes.contact_page_wrapper}>
            <div className={'container'}>
                <div className={'row'}>
                    <div
                        className={
                            'col-lg-6' +
                            ' ' +
                            'col-md-6' +
                            ' ' +
                            'col-sm-6' +
                            ' ' +
                            'col-xs-12'
                        }
                    >
                        <Form
                            ref={formRef}
                            id="contact-form"
                            className={
                                classes.root + ' ' + classes.contact_form
                            }
                            onSubmit={handleSubmit}
                        >
                            <div className={classes.input_field}>
                                <Field label="Full name" required={true}>
                                    <TextInput
                                        field="name"
                                        autoComplete="given-name"
                                        validate={isRequired}
                                        validateOnBlur
                                    />
                                </Field>
                            </div>
                            <div className={classes.input_field}>
                                <Field label="Email" required={true}>
                                    <TextInput
                                        field="email"
                                        autoComplete="email"
                                        validate={combine([
                                            isRequired,
                                            validateEmail
                                        ])}
                                        validateOnBlur
                                    />
                                </Field>
                            </div>
                            <div className={classes.input_field}>
                                <Field label="Phone Number">
                                    <TextInput field="telephone" />
                                </Field>
                            </div>
                            <div className={classes.input_field}>
                                <Field
                                    label="What’s on your mind?"
                                    required={true}
                                >
                                    <TextArea
                                        field="comment"
                                        validate={isRequired}
                                        validateOnBlur
                                    />
                                </Field>
                            </div>
                            <div className={classes.error}>{errorMessage}</div>
                            <div className={classes.success}>
                                {successMessage}
                            </div>
                            <div className={classes.actions}>
                                <Button type="submit" priority="high">
                                    {'Submit'}
                                </Button>
                            </div>
                        </Form>
                    </div>
                    <div
                        className={
                            'col-lg-6' +
                            ' ' +
                            'col-md-6' +
                            ' ' +
                            'col-sm-6' +
                            ' ' +
                            'col-xs-12'
                        }
                    >
                        <div className={classes.conatct_page}>
                            <h3 className={classes.content_page_heading}>
                                Contact Us
                            </h3>
                            <p className={classes.heading_content}>
                                Lorem ipsum dolor sit amet, consectetuer
                                adipiscing elit. Aenean commodo ligula eget
                                dolor. Aenean massa. Cum sociis natoque
                                penatibus et magnis dis parturient montes,
                                nascetur ridiculus mus. Donec quam felis,
                                ultricies nec, pellentesque eu, pretium quis,
                                sem. Nulla consequat massa quis enim.
                            </p>
                        </div>
                        <div className={classes.phone_mail_wrapp}>
                            <p className={'mb-0'}>
                                <span className={classes.icons}>
                                    <FontAwesomeIcon icon={faPhoneAlt} />
                                </span>
                                <span className={classes.phone_number}>
                                    +1(888)478-5268
                                </span>
                            </p>
                            <a href="/">
                                <span className={classes.icons}>
                                    <FontAwesomeIcon icon={faEnvelope} />
                                </span>
                                <span className={classes.email}>
                                    support@cedcommerce.com
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

Contact.propTypes = {
    classes: shape({
        copyright: string,
        root: string,
        tile: string,
        tileBody: string,
        tileTitle: string
    })
};

export default Contact;
