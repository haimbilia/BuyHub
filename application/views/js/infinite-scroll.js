// YO! BuyHub: Infinite scroll for RFQ listing
document.addEventListener('DOMContentLoaded', function () {
    const rfqContainer = document.querySelector('#rfq-listing-container');
    const loader = document.querySelector('#rfq-loader');
    if (!rfqContainer) return;

    let currentPage = 2;
    let loading = false;
    let reachedEnd = false;

    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && !loading && !reachedEnd) {
            loadNextPage();
        }
    }, {
        rootMargin: '300px',
    });

    const loadNextPage = () => {
        loading = true;
        loader.style.display = 'block';

        fetch('/request-for-quotes/ajax-listing', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                page: currentPage,
            }),
        })
            .then((response) => response.text())
            .then((html) => {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const newItems = tempDiv.querySelectorAll('.rfq-item');
                if (newItems.length === 0) {
                    reachedEnd = true;
                    loader.style.display = 'none'; // Hide spinner permanently at end
                    return;
                }

                newItems.forEach((item) => {
                    const col = document.createElement('div');
                    col.className = 'col-lg-4 col-md-6 mb-4';
                    col.appendChild(item);
                    rfqContainer.insertBefore(col, sentinel);
                });
                currentPage++;
                loading = false;
                loader.style.display = 'none';
            })
            .catch((error) => {
                console.error('Error fetching more RFQs:', error);
                loading = false;
                loader.style.display = 'none';
            });
    };

    // Append a sentinel to observe
    const sentinel = document.createElement('div');
    sentinel.id = 'rfq-end-sentinel';
    rfqContainer.appendChild(sentinel);
    observer.observe(sentinel);
    // Fallback for fast scrolling or missed observer trigger
    window.addEventListener('scroll', () => {
    const scrollBottom = window.scrollY + window.innerHeight;
    const pageBottom = document.body.offsetHeight - 300;

    if (scrollBottom >= pageBottom && !loading && !reachedEnd) {
        loadNextPage();
    }
});
});
