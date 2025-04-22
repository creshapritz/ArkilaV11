@extends('layouts.settings')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help and FAQs</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .grid-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow: auto;
            min-height: 100vh;
            width: 700%;
            overflow: hidden;
        }

        .faq-box {
            background-color: #F07324;
            max-width: 1200px;
            width: 100%;
            padding: 30px;
            border-radius: 10px;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden; 
        }

        .faqs-header h2, .faqs-header p {
            text-align: center;
            color: #F9F8F2;
            font-weight: bold;
            margin-bottom: 10px;
        }

        details {
            cursor: pointer;
            margin-top: 10px;
            position: relative;
        }

        details summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #F9F8F2;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
            position: relative;
        }

        details summary:hover {
            background-color: #e6e6e6;
        }

        details p {
            margin-top: 10px;
            color: #333;
            margin-left: 1rem;
            font-size: 16px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        details[open] p {
            max-height: 200px; 
            padding-top: 10px;
        }

        @media (max-width: 1024px) {
            .faq-box {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .faq-box {
                padding: 15px;
            }

            details summary {
                font-size: 14px;
                padding: 10px;
            }

            details p {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .faq-box {
                padding: 10px;
            }

            details summary {
                font-size: 12px;
                padding: 8px;
            }

            details p {
                font-size: 12px;
            }
        }

        .no-faqs {
            text-align: center;
            color: #333;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="grid-container">
        <div class="faq-box">
            <div class="w-full bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:max-w-4xl sm:px-10">
                <div class="mx-auto px-5">
                    <div class="faqs-header">
                        <h2>Help and FAQs</h2>
                        <p>Frequently Asked Questions</p>
                    </div>

                    <div class="mx-auto mt-8 max-w-3xl divide-y divide-neutral-200">
                        @foreach ($faqs as $faq)
                            <div class="py-5">
                                <details>
                                    <summary>
                                        <span>{{ $faq->question }}</span>
                                        <span class="transition">
                                            <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                                <path d="M6 9l6 6 6-6"></path>
                                            </svg>
                                        </span>
                                    </summary>
                                    <p>{{ $faq->answer }}</p>
                                </details>
                            </div>
                        @endforeach
                        @if($faqs->isEmpty())
                            <p class="no-faqs">No FAQs available at this time.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
