window.addEventListener('DOMContentLoaded', () => {
    const backBtn = document.querySelector("#backBtn");
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 200) {
            showElement(backBtn);
        } else {
            hideElement(backBtn);
        }
    });

    initialAnimation();
})

function showElement(element) {
    if (element.classList.contains('d-none')) {
        element.classList.remove('d-none');
    }
}

function hideElement(element) {
    if (!element.classList.contains('d-none')) {
        element.classList.add('d-none');
    }
}
