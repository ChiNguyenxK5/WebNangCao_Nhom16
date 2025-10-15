document.addEventListener('DOMContentLoaded', function () {
    // Lấy các phần tử trong giao diện
    const showPopupBtn = document.querySelector(".login-btn");
    const formPopup = document.querySelector(".form-popup");
    const blurBgOverlay = document.querySelector(".blur-bg-overlay");

    // Hiện popup khi nhấn nút login (chỉ dùng nếu bạn vẫn muốn popup UI)
    if (showPopupBtn) {
        showPopupBtn.addEventListener("click", () => {
            // Nếu bạn đang dùng Breeze thì chuyển hẳn đến trang /login
            window.location.href = "/login";
            // Nếu bạn vẫn muốn dùng popup thì có thể bật dòng sau:
            // document.body.classList.add("show-popup");
        });
    }

    // Ẩn popup khi nhấn nút close hoặc nền mờ
    if (formPopup) {
        const hidePopupBtn = formPopup.querySelector(".close-btn");
        const signupLoginLink = formPopup.querySelectorAll(".bottom-link a");

        if (hidePopupBtn) {
            hidePopupBtn.addEventListener("click", () => {
                document.body.classList.remove("show-popup");
            });
        }

        if (blurBgOverlay) {
            blurBgOverlay.addEventListener("click", () => {
                document.body.classList.remove("show-popup");
            });
        }

        // Chuyển giữa login/signup
        signupLoginLink.forEach(link => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                formPopup.classList[
                    link.id === 'signup-link' ? 'add' : 'remove'
                ]("show-signup");
            });
        });
    }

    // --- Dropdown Avatar ---
    const userProfile = document.querySelector('.user-profile');
    const userDropdown = document.querySelector('.user-dropdown');

    if (userProfile && userDropdown) {
        userProfile.addEventListener('click', function (e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        document.addEventListener('click', function () {
            userDropdown.classList.remove('show');
        });
    }
});
