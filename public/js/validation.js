$(document).ready(function ()
{
    $('#itemSelect').change(function ()
    {
            $('#desktopform').validate({ // initialize the plugin
                rules:
                {
                    brandName:{
                        required: true,
                    },
                    dimension: {
                        required: true,
                    },
                    weight: {
                        required: true,
                        number: true,
                    },
                    processorType: {
                        required: true,
                    },
                    ramSize: {
                        required: true,
                    },
                    cpuCores: {
                        required: true,
                    },
                    hdSize: {
                        required: true,
                    },
                    batteryInfo: {
                        required: true,
                    },
                    modelNumber: {
                        required: true,
                    },
                    price: {
                        required: true,
                        number: true,
                    },
                    message:{
                    },
                }
            });

            $('#laptopform').validate({ // initialize the plugin
                rules:
                {
                    displaySize: {
                        required: true,
                    },
                    cpuCores: {
                        required: true,
                    },
                    processorType: {
                        required: true,
                        number: true,
                    },
                    processorType: {
                        required: true,
                    },
                    hdSize: {
                        required: true,
                    },
                    batteryInfo: {
                        required: true,
                    },
                    ramSize: {
                        required: true,
                    },
                    weight: {
                        required: true,
                        number: true,
                    },
                    brandName: {
                        required: true,
                    },
                    modelNumber: {
                        required: true,
                    },
                    price: {
                        required: true,
                        number: true,
                    },
                    message: {
                    },
                }
            });


            $('#monitorform').validate({ // initialize the plugin
                rules:
                {
                    dimension: {
                        required: true,
                    },
                    weight: {
                        required: true,
                        number: true,
                    },
                    brandName: {
                        required: true,
                    },
                    modelNumber: {
                        required: true,
                    },
                    os: {
                        required: true,
                    },
                    price: {
                        required: true,
                        number: true,
                    },
                    message: {
                    },
                }
            });


            $('#tabletform').validate({ // initialize the plugin
                rules:
                {
                    brandName: {
                        required: true,
                    },
                    display: {
                        required: true,
                    },
                    dimension: {
                        required: true,
                    },
                    weight: {
                        required: true,
                        number: true,
                    },
                    processor: {
                        required: true,
                    },
                    ramSize: {
                        required: true,
                    },
                    cpuCores: {
                        required: true,
                    },
                    hdSize: {
                        required: true,
                    },
                    batteryInfo: {
                        required: true,
                    },
                    modelNumber: {
                        required: true,
                    },
                    os: {
                        required: true,
                    },
                    camera: {
                        required: true,
                    },
                    price: {
                        required: true,
                        number: true,
                    },
                    message: {
                    },
                }
            });


            // $('#televisionform').validate({ // initialize the plugin
            //     rules:
            //     {
            //         dimension: {
            //             required: true,
            //         },
            //         weight: {
            //             required: true,
            //             number: true,
            //         },
            //         brandName: {
            //             required: true,
            //         },
            //         modelNumber: {
            //             required: true,
            //         },
            //         price: {
            //             required: true,
            //             number: true,
            //         },
            //         message: {
            //         },
            //     }
            // });
        });
});
