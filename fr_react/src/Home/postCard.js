import React from "react";

const PostCard = () => {
    return (
        <div className="w-[500px] bg-white rounded-3xl border border-blue-400 shadow-md p-6">
            {/* Header */}
            <div className="flex items-center mb-4">
                <img
                    src="https://placehold.co/40x40"
                    alt="Profile"
                    className="rounded-full w-10 h-10 object-cover mr-3"
                />
                <div>
                    <h3 className="text-blue-500 font-bold">Cristiano Ronaldo</h3>
                    <p className="text-gray-500 text-sm">Professional Soccer Player | Midfielder</p>
                </div>
            </div>

            {/* Post Content */}
            <div className="text-gray-800 text-sm mb-4">
                <p>
                    nefjhf rebfr fefblehfrbf bjrefjbe n jkerf rejbkfejrb jbrekjbfr jbrekjb jkbrkjbfe...
                </p>
                <span className="text-blue-500 italic cursor-pointer">voir plus</span>
            </div>

            {/* Image */}
            <div className="w-full h-40 bg-gray-200 mb-4 rounded-lg overflow-hidden">
                <img
                    src="https://placehold.co/400x200"
                    alt="Logo"
                    className="w-full h-full object-cover"
                />
            </div>

            {/* Footer Icons */}
            <div className="flex justify-between">
                <button className="rounded-full border border-blue-300 p-2 w-20 flex justify-center hover:bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                </button>
                <button className="rounded-full border border-blue-300 p-2 w-20 flex justify-center hover:bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </button>
                <button className="rounded-full border border-blue-300 p-2 w-20 flex justify-center hover:bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </div>
        </div>
    );
};

export default PostCard;