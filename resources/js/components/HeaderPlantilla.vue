<template>
    <div class="content">
        <div class="boxLogo">
            <a :href="home">
                <img id="logo" src="/BroggiProject/public/storage/media/img/logo.svg" alt="Logotip de l'aplicació">
            </a>
        </div>

        <div class="boxTitleGTA">
            Gestió de Trucades d'Assistència
        </div>
    </div>
</template>

<style>

.content {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    height: 5rem;
    width: 80%;
    border-bottom: 1px solid rgba(0,0,0,0.125);
    background-color: #FFFFFF;
}

.boxLogo {
    display: flex;
    height: 5rem;
    width: 5rem;
    justify-content: center;
    align-items: center;
}

#logo {
    height: 4rem;
    width: 4rem;
}

.boxTitleGTA {
    display: flex;
    align-items: center;
    font-family: 'Nunito', sans-serif;
    font-size: 1.5rem;
    width: 15rem;
    margin-left: 1rem;
}

</style>

<script>
    export default {
        data() {
            return {
                home: './home',
            }
        },

        methods: {

        }
    }
</script>
