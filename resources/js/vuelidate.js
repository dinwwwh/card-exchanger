import { helpers } from '@vuelidate/validators';
import * as buildInRules from '@vuelidate/validators/dist/raw.esm';
import { uppercaseFirstLetter } from './utils';

/** Get first error message */
export function getMessage(validation) {
    return validation?.$errors?.[0]?.$message;
}

/** Determine whether a validation has error  */
export function hasError(validation) {
    if (
        validation === false ||
        validation === true ||
        validation === null ||
        validation === undefined
    ) {
        return !!validation;
    }

    return validation.$error;
}

// ============================================================
// ALL RULES
// ============================================================

export const required = (field = 'trường này') =>
    helpers.withMessage(
        () => uppercaseFirstLetter(`${field} là bắt buộc`),
        (val) => helpers.req(val)
    );

export const minLength = (length, field = 'trường này') =>
    helpers.withParams(
        { length },
        helpers.withMessage(
            ({ $params }) =>
                uppercaseFirstLetter(
                    `${field} phải chứa ít nhất ${$params.length} ký tự`
                ),
            (val) => !helpers.req(val) || val.length >= length
        )
    );
