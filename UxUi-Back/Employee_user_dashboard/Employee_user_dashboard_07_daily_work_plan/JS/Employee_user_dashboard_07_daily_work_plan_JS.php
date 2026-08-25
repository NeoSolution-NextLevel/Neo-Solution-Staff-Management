<script>
    var ip_address
    $(document).ready(function ()) {
        // Step 1: Fetch IP address
        fetch('https://api.ipify.org?format=json') .then(response => response.json())
        .then(data => {
            const ip = data.ip;
            // Set the IP address in the input field with ID 'sys_01'
            document.getElementById("sys_01").value = ip;
            console.log("IP Address: " + ip);
})
.catch(error => {
    console.error('Error fetching the IP address:', error);
});
let ip = document.getElemetById("sys_02").value;
//Replace this with the actual IP

fetch('https://ipinfo.io/${ip}/json?token=dd2f449fala7fd') //Replace your token

.then(response => response.json())
.then(data => {
    //output the country information
    console.log("Country:", data.country);
    //Example: Do something with the country information
    document.getElementById("sys_01").value = data.country+ | "+data.timezone+" Service Provider: " +data.org;
    document.getElementById("sys_03").value = data.city+" - "+data.region +" ("+data.loc+")";
})
.catch(error => {
    console.error('Error fetching location details:', error);
});
});

</script>