import { useCallback, useRef, useState } from 'react';
import { useMutation } from '@apollo/react-hooks';

export const useNewsLetter = props => {
    const { query } = props;
    const [subscribing, setSubscribing] = useState(false);
    const [responseData, setResponseData] = useState({});
    const [subscribeNewsLetter, { message: newsLetterError }] = useMutation(
        query
    );

    const errors = [];
    if (newsLetterError) {
        errors.push(newsLetterError.graphQLErrors[0]);
    }

    const formRef = useRef(null);

    const handleSubmit = useCallback(
        async ({ email }) => {
            setSubscribing(true);
            try {
                // Sign in and save the token
                const subscription = '1';
                const response = await subscribeNewsLetter({
                    variables: { email, subscription }
                });
                setResponseData(response.data.newsletter);
                setSubscribing(false);
            } catch (error) {
                if (process.env.NODE_ENV === 'development') {
                    console.error(error);
                }
                setSubscribing(false);
            }
        },
        [subscribeNewsLetter]
    );

    return {
        errors,
        formRef,
        handleSubmit,
        isBusy: subscribing,
        responseData
    };
};
