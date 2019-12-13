import { createActions } from 'redux-actions';

const prefix = 'CED';
const actionTypes = ['CUSTOM_APIS'];

const actionMap = {
    GET_HOMENAVIGATION_DETAILS: {
        REQUEST: null,
        RECEIVE: null
    },
    CONTACT_FORM: {
        REQUEST: null,
        RECEIVE: null
    }
};

export default createActions(actionMap, ...actionTypes, { prefix });
