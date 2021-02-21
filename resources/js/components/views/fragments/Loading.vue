<template>
    <div class="loader_father">
        <div class="loader-container">
            <div class="loader"></div>
            <div class="loader2"></div>
            <div class="loader3"></div>
            <div class="totalLoading">
                <strong>Totalplay® <br />
                Cargando... </strong>
            </div>
        </div>
    </div>
</template>

<style scoped >
.loader_father {
    z-index: 3000;
    position: fixed;
    background-color: rgba(0, 0, 0, 0.8);
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.loader-container {
    position: relative;
    width: 420px;
    height: 420px;
}

.loader-container .totalLoading {
    position: absolute;
    top: 44%;
    width: 100%;
    height: 10%;
    text-align: center;
    font-size: 22px;
    font-family: "PT Sans", Verdana, sans-seri;
    animation: totalLoading 5.4s linear infinite;
}

.loader-container .loader {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    border: solid 28px transparent;
    border-top-color: #f7fa1d;
    border-left-color: #f7fa1d;
    border-radius: 50%;
    animation: loader 1.5s linear infinite;
}

.loader-container .loader2 {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 70%;
    height: 70%;
    border: solid 24px transparent;
    border-top-color: #ea1dfa;
    border-left-color: #ea1dfa;
    border-radius: 50%;
    animation: loader2 1.7s linear infinite;
}

.loader-container .loader3 {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 50%;
    height: 50%;
    border: solid 20px transparent;
    border-top-color: #1dfad0;
    border-left-color: #1dfad0;
    border-radius: 50%;
    animation: loader3 2s linear infinite;
}

@keyframes totalLoading {
    0% {
        color: red;
    }
    33% {
        color: green;
    }
    66% {
        color: blue;
    }
    99% {
        color: pink;
    }
}

@keyframes loader {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}

@keyframes loader2 {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(-360deg);
    }
}

@keyframes loader3 {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}

@media screen and (min-width: 0px) and (max-width: 640px) {
    .loader-container {
        width: 280px;
        height: 280px;
    }

    .loader-container .loader {
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
    }

    .loader-container .loader2 {
        top: 50%;
        left: 50%;
        width: 70%;
        height: 70%;
    }

    .loader-container .loader3 {
        top: 50%;
        left: 50%;
        width: 30%;
        height: 30%;
    }
}

</style>
