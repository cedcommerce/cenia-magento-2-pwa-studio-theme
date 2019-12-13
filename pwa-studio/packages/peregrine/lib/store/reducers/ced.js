import { handleActions } from 'redux-actions';

import { Util } from '../../index';
const { BrowserPersistence } = Util;

const storage = new BrowserPersistence();

import actions from '../actions/ced';

export const name = 'ced';

const isSignedIn = () => !!storage.getItem('signin_token');

const initialState = {
    currentUser: {
        email: '',
        firstname: '',
        lastname: ''
    },
    getDetailsError: null,
    isGettingDetails: false,
    isResettingPassword: false,
    isSignedIn: isSignedIn(),
    resetPasswordError: null,
    token: storage.getItem('signin_token')
};

const reducerMap = {
    [actions.getHomenavigationDetails.receive]: (state, { payload }) => {
        return {
            ...state,
            getHomenavigationDetails: payload
        };
    },
    [actions.contactForm.receive]: (state, { payload }) => {
        return {
            ...state,
            contactForm: payload
        };
    }
};

export default handleActions(reducerMap, initialState);
