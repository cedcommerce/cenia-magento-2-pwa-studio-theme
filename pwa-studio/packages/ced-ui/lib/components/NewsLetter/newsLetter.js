import React from 'react';
import { shape, string } from 'prop-types';
import { Form } from 'informed';
import Button from '../Button';
import Field from '../Field';
import TextInput from '../TextInput';

import { isRequired, validateEmail } from '../../util/formValidators';
import combine from '../../util/combineValidators';
import { mergeClasses } from '../../classify';
import defaultClasses from './newsLetter.css';
import { useNewsLetter } from '@magento/peregrine/lib/talons/NewsLetter/useNewsLetter';
import NEWSLETTER_MUTATION from '@magento/ced-ui/lib/queries/subscribeNewsLetter.graphql';

const NewsLetter = props => {
    const classes = mergeClasses(defaultClasses, props.classes);
    const talonProps = useNewsLetter({
        query: NEWSLETTER_MUTATION
    });

    const { formRef, handleSubmit, responseData } = talonProps;

    return (
        <div className={defaultClasses.subscription_wrapper}>
            <div className={defaultClasses.newsLetter_heading}>
                <h3>Subscribe to our Newsletter </h3>
                <p>To get our latest offers</p>
            </div>
            <Form
                ref={formRef}
                className={classes.root}
                onSubmit={handleSubmit}
            >
                <div className={defaultClasses.input_group}>
                    <Field>
                        <TextInput
                            autoComplete="email"
                            field="email"
                            validate={combine([isRequired, validateEmail])}
                        />
                    </Field>
                    <div className={defaultClasses.input_group_append}>
                        <Button
                            className={
                                defaultClasses.footer_form_btn +
                                ' ' +
                                defaultClasses.filled
                            }
                            type="submit"
                        >
                            {'Submit'}
                        </Button>
                    </div>
                </div>
                <React.Fragment>
                    {responseData.success == 'true' && (
                        <div className={classes.success}>
                            {responseData.message}
                        </div>
                    )}
                    {responseData.success == 'false' && (
                        <div className={classes.error}>
                            {responseData.message}
                        </div>
                    )}
                </React.Fragment>
            </Form>
        </div>
    );
};

NewsLetter.propTypes = {
    classes: shape({
        copyright: string,
        root: string,
        tile: string,
        tileBody: string,
        tileTitle: string,
        signInButton: string
    })
};

export default NewsLetter;
