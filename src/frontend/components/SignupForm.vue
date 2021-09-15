
<template>
    <div class="signup-form">
        <form v-if="!successForm" @submit.prevent>
            <div class="input-group">
                <label>Name<sup>*</sup></label>
                <input type="text" required v-model="name">
            </div>
            <div class="input-group">
                <label>Email<sup>*</sup></label>
                <input type="email" required v-model="email">
            </div>
            <div class="input-group">
                <label>Password<sup>*</sup></label>
                <input type="password" required v-model="password">
            </div>
            <div class="input-group">
                <label>Skills<sup>*</sup></label>
                <input type="text" required v-model="tempSkill" v-on:keyup.188="addSkills">
                <p class="hints">(e.g) Add skills with "<strong>comma</strong>"</p>
                <div class="skills" v-if="skills.length">
                    <span @click="deleteSkill(skill)" v-for="skill in skills" :key="skill" title="Click to Remove">
                        {{skill}}
                    </span>
                </div>
            </div>
            <div class="input-group">
                <label>Role<sup>*</sup></label>
                <select v-model="role">
                    <option value="designer">Web Designer</option>
                    <option value="developer">Web Developer</option>
                </select>
            </div>
            <div class="input-group input-checkbox">
                <input type="checkbox" id="terms" required v-model="terms">
                <label for="terms">Accept terms &amp; conditions<sup>*</sup></label>
            </div>
            <div class="submit">
                <button @click="handleSubmit">create an account</button>
            </div>
        </form>
        <div v-show="successForm" class="thank-you-msg">
            <h1><strong>"{{name}}",</strong> Thank you for Signup!</h1>
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            name: "",
            email: '',
            password: '',
            tempSkill: '',
            skills: [],
            role: 'designer',
            terms: false,
            successForm: false
        }
    },
    methods: {
        addSkills(e) {
            if (e.key === "," && this.tempSkill) {
            const symble_rplc = this.tempSkill.replace(',', '');
                if (!this.skills.includes(symble_rplc)) {
                    this.skills.push(symble_rplc);
                }
                this.tempSkill = "";
            }
        },
        deleteSkill(skill) {
            this.skills = this.skills.filter((item) => {
                return skill !== item
            })
        },
        handleSubmit() {
            if (!this.name || !this.email || !this.password || !this.terms) {
                return;
            }
            this.successForm = true;

            setTimeout(() => {
                this.successForm = false

                this.name = '';
                this.email = '';
                this.password = '';
                this.skills = [];
                this.role = 'designer';
                this.terms = false;
            }, 3500);

            console.log('Name: '+this.name);
            console.log('Email: '+this.email);
            console.log('Password: '+this.password);
            console.log('Skills: '+this.skills);
            console.log('Role: '+this.role);
            console.log('Terms: '+this.terms);
        }
    },
    
}
</script>

<style>
    sup {
        color: #bd0404;
        font-size: 80%;
    }
    .signup-form {
        max-width: 610px;
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 0 30px rgb(0 0 0 / 10%);
        padding: 30px;
        margin: 30px 0 0 0;
    }
    .signup-form form .input-group + .input-group {
        margin-top: 15px;
    }
    .signup-form form .input-group input, .signup-form form .input-group select {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 4px;
        line-height: 20px;
    }
    .signup-form form .input-group select {
        font-size: 16px;
    }
    .signup-form form .input-group input[type="checkbox"] {
        width: 25px;
    }
    .signup-form form .input-group input[type="checkbox"]:after {
        left: 8px;
        top: 4px;
    }
    .thank-you-msg h1 {
        font-size: 24px;
        font-weight: 300;
        text-align: center;
    }
    .thank-you-msg h1 strong {
        font-weight: 600;
    }
    .signup-form .skills {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        margin-top: 10px;
    }
    .signup-form .skills span + span {
        margin-left: 8px;
    }
    .signup-form .skills span {
        background: #ddd;
        border-radius: 30px;
        padding: 1px 10px;
        font-size: 14px;
        cursor: pointer;
    }
    .signup-form .hints {
        font-size: 12px;
        font-style: italic;
        color: #aaaaaa;
    }
    .signup-form .hints strong {
        color: #666;
        font-weight: 700;
    }
</style>

