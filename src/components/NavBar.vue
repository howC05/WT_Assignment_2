<template>
    <div class="navbar">
        <div class="icon">
            <h2 class="logo">W.Tech.</h2>
        </div>
        <div class="menu">
            <ul>
                <li><router-link to="/">HOME</router-link></li>
                <li><router-link to="/">ABOUT</router-link></li>
                <li><router-link to="/course-materials">COURSE MATERIALS</router-link></li>
                <li><router-link to="/assessment">ASSESSMENT</router-link></li>
                <li><router-link to="/user-management">USER MANAGEMENT</router-link></li>
            </ul>
        </div>
        <div class="search">
            <input class="srch" type="search" placeholder="Type To Find" />
            <a href="#"><button class="btn">Find</button></a>
        </div>
    </div>
</template>

<script>
export default {
    name: "Navbar",
};
</script>

<style scoped>
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    height: 75px;
    padding: 0 20px;
}

.icon {
    display: flex;
    align-items: center;
}

.logo {
    color: #fc8d1e;
    font-size: 20px;
    font-family: Cambria;
}

.menu {
    flex-grow: 1;
    display: flex;
    justify-content: center;
}

.menu ul {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu ul li {
    margin: 0 15px;
}

.menu ul li a {
    text-decoration: none;
    color: #fff;
    font-family: Arial;
    font-weight: bold;
    transition: 0.4s ease-in-out;
}

.menu ul li a:hover {
    color: #ff7200;
}

.search {
    width: 330px;
    float: left;
    margin-left: 20px;
}

.srch {
    font-family: 'Times New Roman';
    width: 150px;
    height: 30px;
    background: transparent;
    border: 1px solid #ff7200;
    color: #fff;
    border-right: none;
    font-size: 16px;
    padding: 5px;
    border-bottom-left-radius: 5px;
    border-top-left-radius: 5px;
}

.btn {
    width: 80px;
    height: 30px;
    background: #ff7200;
    border: 2px solid #ff7200;
    color: #fff;
    font-size: 15px;
    border-bottom-right-radius: 5px;
    border-top-right-radius: 5px;
    transition: 0.2s ease;
    cursor: pointer;
}

.btn:hover {
    color: black;
}

.btn:focus,
.srch:focus {
    outline: none;
}
</style>