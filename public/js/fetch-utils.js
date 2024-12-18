export function fetchData(url, onSuccess, onError) {
    fetch(url)
        .then((response) => response.json())
        .then(onSuccess)
        .catch(onError);
}
