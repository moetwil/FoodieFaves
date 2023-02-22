<template>
    <li class="card py-3 px-3 col my-3">
        <div class="d-flex">
            <div class="left">
                <span>
                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="profile-pict-img img-fluid"
                        alt="" />
                </span>
            </div>
            <div class="right">
                <h4>
                    Luc Moetwil
                    <span class="gig-rating text-body-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1792 1792" width="15" height="15">
                            <path fill="currentColor"
                                d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z">
                            </path>
                        </svg>
                        5.0
                    </span>
                </h4>
                <div class="review-description">
                    <p>
                        The process was smooth, after providing the required info, Pragyesh sent me an
                        outstanding packet of wireframes. Thank you a lot!
                    </p>

                    <div class="rating d-flex justify-content-center flex-column mt-2">
                        <span class="text-body-3">Eten: 4.2</span>
                        <span class="text-body-3">Bediening: 6.1</span>
                        <span class="text-body-3">Prijs-kwaliteit: 1/5</span>
                    </div>

                </div>
                <span class="publish py-3 d-inline-block w-100">Published 4 weeks ago</span>
            </div>
        </div>
    </li>
</template>

<script setup lang="ts">

</script>

<style scoped>
body {
    margin-top: 20px;
    background: #eee;
}

.text-body-3 {
    font-size: 14px;
}

.review-list ul li .left span {
    width: 32px;
    height: 32px;
    display: inline-block;
}

.review-list ul li .left {
    flex: none;
    max-width: none;
    margin: 0 10px 0 0;
}

.review-list ul li .left span img {
    border-radius: 50%;
}

.review-list ul li .right h4 {
    font-size: 16px;
    margin: 0;
    display: flex;
}

.review-list ul li .right h4 .gig-rating {
    display: flex;
    align-items: center;
    margin-left: 10px;
    color: #ffbf00;
}

.review-list ul li .right h4 .gig-rating svg {
    margin: 0 4px 0 0px;
}


.review-list ul li .right {
    flex: auto;
}

.review-list ul li .review-description {
    margin: 20px 0 0;
}

.review-list ul li .review-description p {
    font-size: 17px;
    margin: 0;
}

.review-list ul li .publish {
    font-size: 13px;
    color: #95979d;
}

ul,
ul li {
    list-style: none;
    margin: 0px;
}

.helpful-thumbs,
.helpful-thumb {
    display: flex;
    align-items: center;
    font-weight: 700;
}
</style>