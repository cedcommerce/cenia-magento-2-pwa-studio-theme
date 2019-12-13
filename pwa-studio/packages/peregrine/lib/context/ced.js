import React, { createContext, useContext, useMemo } from 'react';
import { connect } from 'react-redux';

import actions from '../store/actions/ced/actions';
import * as asyncActions from '../store/actions/ced/asyncActions';
import bindActionCreators from '../util/bindActionCreators';

const CedContext = createContext();

const CedContextProvider = props => {
    const { actions, asyncActions, children, cedState } = props;
    console.log(props);
    const cedApi = useMemo(
        () => ({
            actions,
            ...asyncActions
        }),
        [actions, asyncActions]
    );
    console.log(cedApi);
    const contextValue = useMemo(() => [cedState, cedApi], [cedApi, cedState]);

    return (
        <CedContext.Provider value={contextValue}>
            {children}
        </CedContext.Provider>
    );
};

const mapStateToProps = ({ ced }) => ({ cedState: ced });

const mapDispatchToProps = dispatch => ({
    actions: bindActionCreators(actions, dispatch),
    asyncActions: bindActionCreators(asyncActions, dispatch)
});

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(CedContextProvider);

export const useCedContext = () => useContext(CedContext);
