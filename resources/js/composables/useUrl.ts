const currentUrl = new URL(window.location.href);

const navigate = function (url?: string) {
    window.location.href = url || currentUrl.href;
}

export default function useUrl() {
    return {
        currentUrl,
        navigate,
    };
}
