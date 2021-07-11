/**
 * Created by Mayank on 02-09-2017.
 */

function showLoader() {
    quoteAndAuthor = produceQuote();
    quote = quoteAndAuthor[0];
    author = quoteAndAuthor[1];
    document.getElementById('quote').innerHTML = ("<b>\"</b>" + quote + "<b>\"</b>");
    document.getElementById('author').innerHTML = ("- " + author);
    freezeAllContent('all_visible_content');
    $('#loader').fadeIn(400);
}

function dismissLoader() {
    defreezeAllContent('all_visible_content');
    $('#loader').fadeOut(400);
}

function produceQuote() {
    allQuotes = [
        "True sign of intelligence is not knowledge but imagination.::::Albert Einstein",
        "No problem can be solved from the same level of consciousness that created it.::::Albert Einstein",
        "The important thing is not to stop questioning. Curiosity has its own reason for existing.::::Albert Einstein",
        "If you can't explain it simply, you don't understand it well enough.::::Albert Einstein",
        "The fool doth think he is wise, but the wise man knows himself to be a fool.::::William Shakespeare",
        "It is not in the stars to hold our destiny but in ourselves.::::William Shakespeare",
        "We know what we are, but not what we may be.::::William Shakespeare",
        "Brevity is the soul of wit.::::William Shakespeare",
        "I defy you, stars.::::William Shakespeare",
        "If music be the food of love, play on.::::William Shakespeare",
        "Thought is free.::::William Shakespeare",
        "Resist much, obey little.::::Walt Whitman",
        "Do anything, but let it produce joy.::::Walt Whitman",
        "That the powerful play goes on, and you will contribute a verse.::::Walt Whitman",
        "The best way to find out if you can trust somebody is to trust them.::::Ernest Hemmingway",
        "Be the change that you wish to see in the world.::::Mahatma Gandhi ",
        "Live as if you were to die tomorrow. Learn as if you were to live forever.::::Mahatma Gandhi ",
        "Truth never damages a cause that is just.::::Mahatma Gandhi ",
        "Action expresses priorities.::::Mahatma Gandhi ",
        "Speak only if it improves upon the silence.::::Mahatma Gandhi ",
        "Everything you can imagine is real.::::Pablo Picasso ",
        "Every child is an artist. The problem is how to remain an artist once he grows up.::::Pablo Picasso ",
        "Art is the lie that enables us to realize the truth.::::Pablo Picasso ",
        "Art washes away from the soul the dust of everyday life.::::Pablo Picasso ",
        "Learn the rules like a pro, so you can break them like an artist.::::Pablo Picasso ",
        "It takes a very long time to become young.::::Pablo Picasso ",
        "I do not seek. I find.::::Pablo Picasso ",
        "There is only one way to see things, until someone shows us how to look at them with different eyes::::Pablo Picasso ",
        "In a conflict between the heart and the brain, follow your heart.::::Swami Vivekananda",
        "In a day, when you don't come across any problems - you can be sure that you are travelling in a wrong path.::::Swami Vivekananda",
        "The greatest sin is to think yourself weak::::Swami Vivekanand",
        "They alone live, who live for others.::::Swami Vivekananda ",
        "Arise, awake, stop not till the goal is reached.::::Swami Vivekananda",
        "Neither seek nor avoid, take what comes.::::Swami Vivekananda ",
        "The fire that warms us can also consume us; it is not the fault of the fire.::::Swami Vivekananda ",
        "He who struggles is better than he who never attempts.::::Swami Vivekananda ",
        "A true artist is not one who is inspired, but one who inspires others.::::Salvador Dali",
        "It's better to have loved and lost than do forty pounds of laundry a week.::::Salvador Dalí ",
        "The one thing the world will never have enough of is the outrageous.::::Salvador Dalí ",
        "Intelligence without ambition is a bird without wings.::::Salvador Dalí ",
        "Don't loaf and invite inspiration; light out after it with a club.::::Jack London",
        "But I am I. And I won't subordinate my taste to the unanimous judgment of mankind.::::Jack London",
        "Fear urged him to go back, but growth drove him on.::::Jack London",
        "The question is not what you look at, but what you see.::::Henry David Thoreau",
        "Rather than love, than money, than fame, give me truth.::::Henry David Thoreau",
        "As if you could kill time without injuring eternity.::::Henry David Thoreau",
        "Our truest life is when we are in dreams awake.::::Henry David Thoreau ",
        "This world is but canvas to our imaginations.::::Henry David Thoreau",
        "I have not failed. I've just found 10,000 ways that won't work.::::Thomas A. Edison ",
        "If we all did the things we are really capable of doing, we would literally astound ourselves.::::Thomas A. Edison ",
        "When you have exhausted all possibilities, remember this - you haven't.::::Thomas A. Edison ",
        "Everything comes to him who hustles while he waits.::::Thomas Edison ",
        "I find out what the world needs. Then I go ahead and try to invent it::::Thomas A. Edison ",
        "I don't care that they stole my idea . . I care that they don't have any of their own::::Nikola Tesla ",
        "The present is theirs; the future, for which I really worked, is mine.::::Nikola Tesla ",
        "Our virtues and our failings are inseparable, like force and matter. When they separate, man is no more::::Nikola Tesla ",
        "Gain more, waste less, spend efficiently, learn.::::Nikola Tesla",
        "A new idea must not be judged by its immediate results.::::Nikola Tesla",
        "Nothing in life is to be feared. It is only to be understood.::::Marie Curie",
        "I was taught that the way of progress is neither swift nor easy.::::Marie Curie ",
        "We must believe that we are gifted for something and that this thing, at whatever cost, MUST be attained.::::Marie Curie ",
        "The journey matters as much as the goals.::::Kalpana Chawla",
        "You are just your intelligence.::::Kalpana Chawla",
        "Don't get bogged down by the notion of limits. There aren't any.::::Sunita Williams",
        "One child, one teacher, one book, one pen can change the world.::::Malala Yousafzai",
        "They say ignorance is bliss.... they're wrong ::::Franz Kafka ",
        "Beyond a certain point there is no return. This point has to be reached.::::Franz Kafka ",
        "I lack nothing. I only needed myself.::::Franz Kafka ",
        "Even the merest gesture is holy if it is filled with faith.::::Franz Kafka ",
        "etter pass boldly into that other world, in the full glory of some passion, than fade and wither dismally with age.::::James Joyce",
        "Life is too short to read a bad book.::::James Joyce ",
        "A man of genius makes no mistakes. His errors are volitional and are the portals of discovery.::::James Joyce",
        "Can't bring back time. Like holding water in your hand.::::James Joyce",
        "Arrange whatever pieces come your way.::::Virginia Woolf ",
        "Forever is composed of nows.::::Emily Dickinson ",
        "I dwell in possibility…::::Emily Dickinson ",
        "Truth is so rare, it is delightful to tell it.::::Emily Dickinson ",
        "I tasted life.::::Emily Dickenson ",
        "If your Nerve, deny you. Go above your Nerve::::Emily Dickinson ",
        "The only tired I was, was tired of giving in.::::Rosa Parks ",
        "It does not do to dwell on dreams and forget to live.::::J.K. Rowling",
        "I had a dream.::::Martin Luther King"
    ];
    quoteIndex = parseInt((Math.random() * 1000) % allQuotes.length);
    selectedQuoteAndAuthor = allQuotes[quoteIndex];
    quoteAndAuthor = selectedQuoteAndAuthor.split("::::");
    return quoteAndAuthor;
}