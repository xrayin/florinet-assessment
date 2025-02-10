<script>
    export function truncateSentence(sentence, limit) {
        if (sentence.length <= limit) {
            return sentence;
        }

        return sentence.slice(0, limit) + '...';
    }
</script>
