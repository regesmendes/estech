<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p>As a solution for the test, I wrote a small application using Laravel 8 with some Vue basics.</p>
                <p>
                    I applied a number of features and resources that I thought were important after reading the requirements. <br>
                    So, I started by building two MySQL Stored Procedures: importPrices, to import the cvs file into the DB; and getPrices, to query the lowest price on the DB.<br>
                    I also created a few indexes to optimize the price search on DB, as the query cost without them was concerning.
                </p>
                <p>
                    For the app itself, I created a simple architecture with a web-router to redirect all public incoming requests to the Vue application, which will interact with the backend through an API. I made a diagram for an overview.<br>
                    <img src="https://lh3.googleusercontent.com/mEH0n39UtUgUl9ZGW__qVCMqN_noC94qWlKknibxjLVaqPkY5cN_kX5rlTRuL36iGlq9dopvG5uC6KjeRe1ETgf1qAN55ucErfVlJMS44pQIabv2qKhppP10al6roQJSVHkd_ibN8nwFbGrL6UXbOVVkAz60E28I3YxXRPJsM_N-LJ3oIr7zn1taJ7TohJ3M_gU6v2roAtTjWWb2unfvaBzmLMlYy-Uw4EMVY1B2w8tMADuXRkWrurWQQIrC_X-gHBZmsPCBEBadCKRY_qHUnaX3Zfob2zZFqtHGeHd3iyEYZe-tJWXZ9RW3xR9-ZKDMwLyEX2_PX1mEDmihNNic2LxAmPKFzs6pUX5II9dckddAmIf9fbBBO8sHhlH5AZdsx7Xi44HwGhJKvx2IFIWu5vNlm6F4XRtrFSp3GjpDmHirn52KLTVh4bi17HODBRI2mwqpKuqxneSB8h3P2Udna4LIfyG2_Nq55TELAbU7beM3lExCFOBS3GdPHPKcLMbKf8b-AfMNSiqdqFUNQlOAief_bIqHxpFD0hscV_we3Pp55Mg1NwsQZ6oH_xkxEuhKG1WvWv47xO6BI78Qkv5UT86N9LzpFzWcjahwiyJG7fYDT4ugowMcGyoTukec4P5cDlbWQEvSzM_OoqM00ByVYzRRvpZrjmaL5RIZvm5CUi5ezFvlVZ0IK3zBbiocgg=w845-h534-no?authuser=0" /><br>
                    <small>The app and DB are placed on separated containers, providing scalability.</small>
                </p>
                <p>The Vue app loads the live-prices when started, and stores it on the client memory.</p>
                <p>The UI allows the user to input one or more product codes (sku) separated by commas, and one optional account code.</p>
                <p>
                    Once a query is submitted, the app will search the params on the live-feed considering the following rules:<br>
                    - user informed an account: then price for each product can be public (no account assigned) or private (assinged to the informed account);<br>
                    - user left account field empty: then price needs to be public (no account assigned);<br>
                    For both cases, if it finds more than one price, it will take the lowest one.
                </p>
                <p>
                    Since the UI allows more than one product to be queried at once, the app will take care of those that were not found on the live feed and check DB, applying the same rules regarding the informed account.
                </p>
                <p>To create DB entities:</p>
                <p class="alert alert-dark">php artisan migrate</p>
                <p>To import the csv file:</p>
                <p class="alert alert-dark">php artisan import:prices &lt;file_name&gt;</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div><strong>by Reges Barbosa Mendes</strong></div>
                <small>feel free to <a href="mailto:reges.mendes@gmail.com">reach out</a>.</small>
            </div>
        </div>
       
    </div>
</template>

<script>
export default {
    name: "About"
}
</script>