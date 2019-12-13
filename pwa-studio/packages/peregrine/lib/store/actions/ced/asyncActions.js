import { Magento2 } from '../../../RestApi';
import BrowserPersistence from '../../../util/simplePersistence';
import { refresh } from '../../../util/router-helpers';

import actions from './actions';

const { request } = Magento2;
const storage = new BrowserPersistence();

export const getNavigationDetails = () => {
    return async function thunk(...args) {
        const [dispatch, getState] = args;
        const { ced } = getState();

        try {
            if (storage.getItem('nav_details')) {
                const navDetails = storage.getItem('nav_details');
                dispatch(actions.getHomenavigationDetails.receive(navDetails));
            } else {
                const navDetails = await request('/rest/V1/getNavigation', {
                    method: 'GET'
                });
                setNavDetails(navDetails);
                dispatch(actions.getHomenavigationDetails.receive(navDetails));
            }
        } catch (error) {
            dispatch(actions.getHomenavigationDetails.receive(error));
        }
    };
};

export const submitContactForm = details =>
    async function thunk(...args) {
       
        const [dispatch] = args;
        try {
            if (typeof details === 'undefined') {
                details = '';
            }

            const response = await request('/rest/V1/saveContactForm', {
                method: 'POST',
                body: JSON.stringify(details)
            });
            console.log(response);
            var responseData = response[0];
            dispatch(actions.contactForm.receive(responseData));
        } catch (error) {
            dispatch(actions.contactForm.receive(error));
            throw error;
        }
    };

async function setNavDetails(navDetails) {
    return storage.setItem('nav_details', navDetails, 360000);
}
