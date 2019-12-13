import { useCallback, useEffect } from 'react';
import { useUserContext } from '@magento/peregrine/lib/context/user';
import { useCedContext } from '@magento/peregrine/lib/context/ced';
import { useAppContext } from '@magento/peregrine/lib/context/app';

export const useHeader = () => {
    const [
        { hasBeenOffline, isOnline, searchOpen },
        { toggleSearch }
    ] = useAppContext();
   
    const [{ currentUser,isSignedIn }, { signOut }] = useUserContext();
   
    const handleSearchTriggerClick = useCallback(() => {
        toggleSearch();
    }, [toggleSearch]);

    const handleSignOut = useCallback(() => {
        // TODO: Get history from router context when implemented.
        signOut({ history: window.history });
    }, [signOut]);

    return {
        handleSearchTriggerClick,
        hasBeenOffline,
        isOnline,
        searchOpen,
        currentUser,
        handleSignOut,
        isSignedIn
    };
};

export const useNavigation = () => {
    const [details, { getNavigationDetails }] = useCedContext();
    const { getHomenavigationDetails: navdetails } = details;

    useEffect(() => {
    (async function anyNameFunction() {
        await getNavigationDetails();
      })();
    }, [getNavigationDetails]);
    return {
        navdetails
    };
};
