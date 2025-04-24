document.addEventListener("DOMContentLoaded", function () {
    let type = 'login'
    console.log("Auth init")
    const form = document.getElementById('login-form');
    const email = document.getElementById('email');
    let username = document.getElementById('username');
    let usernameL = document.getElementById('username-l');
    const pass = document.getElementById('password');
    const sBtn = document.getElementById('s-btn');
    const changeType = document.getElementById('change-type');
    const title = document.getElementById('title')
    sBtn.innerHTML = type;

    const toggleUsernameField = () => {
        if (type === 'signup') {
            username.style.display = 'block';
            usernameL.style.display = 'block';
        } else {
            username.style.display = 'none';
            usernameL.style.display = 'none'
        }
    };

    toggleUsernameField();

    changeType.addEventListener('click', () => {
        console.log("change type")
        type = (type === 'login') ? 'signup' : 'login';
        sBtn.innerHTML = type == 'signup' ? "Sign Up" : "Login";
        title.innerHTML = type == 'signup' ? "Sign Up" : "Login";
        changeType.innerHTML = type == 'signup' ? "Login" : "Signup";
        toggleUsernameField()
    });

    form.addEventListener("submit", (e) => {
        e.preventDefault()
        let data = {
            fType: type,
            email: email.value.trim(),
            password: pass.value
        }
        if (type == 'signup') {
            data.username = username.value.trim();
        }
        console.log(data)
        fetch("../../app/controllers/authController.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
            .then((res) => res.json())
            .then((data) => {
                console.log(data)
                if (data.success) {
                    console.log('success')
                    if (type == 'signup') {
                        console.log('signup')
                        type = 'login'
                        sBtn.innerHTML = type == 'signup' ? "Sign Up" : "Login";
                        title.innerHTML = type == 'signup' ? "Sign Up" : "Login";
                        changeType.innerHTML = type == 'signup' ? "Login" : "Signup";
                        email.value = ''
                        pass.valie = ''
                        toggleUsernameField()
                    }
                    if (data.redirect != undefined) {
                        console.log("Redirecting")
                        window.location.href = data.redirect;
                    }
                } else {
                    console.log(data.error);
                }
            })
            .catch((err) => console.log(err))
    })
})